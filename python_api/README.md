# 🧠 Micro-service IA - Détection Rétinopathie

Ce dossier contient l'API Python (Flask) chargée d'analyser les images de fond d'œil envoyées par l'application Laravel.

Elle utilise le modèle **Deep Learning** `AsmaaElnagger/Diabetic_RetinoPathy_detection` via la librairie Hugging Face Transformers.

---

## 📋 Prérequis

* Python 3.9 ou supérieur.
* Pip (Gestionnaire de paquets Python).

---

## 🛠️ Installation

Il est **impératif** d'utiliser un environnement virtuel pour ne pas créer de conflits avec les autres projets sur votre machine.

### 1. Création de l'environnement virtuel (Venv)

Ouvrez un terminal **dans ce dossier** (`python_api/`) et lancez :

```bash
# Windows
python -m venv env ##Nommez le comme vous voulez

# Mac / Linux
python3 -m venv env

### 2. Activez l'environnement virtuel (env)

# Windows
env\Scripts\activate


### 3. Installation des librairies

pip install -r requirements.txt 
## ou ##
pip install flask torch transformers pillow


### 1. Lancez le modèle
python app.py



###############################################################################################################---