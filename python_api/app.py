import os
import torch
from flask import Flask, request, jsonify
from PIL import Image
from transformers import AutoImageProcessor, AutoModelForImageClassification

app = Flask(__name__)

# --- CONFIGURATION ---
MODEL_ID = "AsmaaElnagger/Diabetic_RetinoPathy_detection"
print(f"🔄 Chargement du modèle {MODEL_ID}...")

try:
    processor = AutoImageProcessor.from_pretrained(MODEL_ID)
    model = AutoModelForImageClassification.from_pretrained(MODEL_ID)
    print("✅ Modèle chargé et prêt !")
except Exception as e:
    print(f"❌ Erreur chargement modèle : {e}")
    model = None

CLASSES = {
    0: "Stade 0 : Sain ",
    1: "Stade 1 : Légère ",
    2: "Stade 2 : Modérée ",
    3: "Stade 3 : Sévère ",
    4: "Stade 4 : Proliférante "
}

@app.route('/predict', methods=['POST'])
def predict():
    if model is None: 
        return jsonify({"error": "Modèle non chargé"}), 500

    if 'file' not in request.files:
        return jsonify({"error": "Aucun fichier reçu"}), 400
    
    file = request.files['file']
    
    try:
        # 1. Ouverture de l'image (Directement depuis la mémoire, pas besoin de sauvegarder)
        image = Image.open(file.stream).convert("RGB")

        # 2. Prétraitement
        inputs = processor(images=image, return_tensors="pt")

        # 3. Prédiction
        with torch.no_grad():
            outputs = model(**inputs)
            logits = outputs.logits
            probabilities = torch.nn.functional.softmax(logits, dim=-1)
            
            score_max, index_max = torch.max(probabilities, dim=-1)
            idx = index_max.item()
            confidence = round(score_max.item() * 100, 2)

        # 4. Formatage du résultat
        # On essaie de récupérer le label exact si le modèle en a
        label_id = idx
        if hasattr(model.config, 'id2label') and model.config.id2label:
            label_id = int(model.config.id2label[idx])
            
        result_text = CLASSES.get(label_id, f"Stade {label_id}")

        # RÉPONSE JSON POUR LARAVEL
        return jsonify({
            "success": True,
            "result": result_text,
            "confidence": confidence,
            "probabilities": probabilities.tolist()
        })

    except Exception as e:
        return jsonify({"success": False, "error": str(e)}), 500

if __name__ == '__main__':
    # On lance sur le port 5001 pour ne pas gêner Laravel (8000)
    app.run(host='0.0.0.0', port=5001, debug=False)