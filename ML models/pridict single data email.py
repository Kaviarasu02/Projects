import pickle
import numpy as np

# Load the saved model and vectorizer
model = pickle.load(open('xgb_model.pkl', 'rb'))
vectorizer = pickle.load(open('tfidf_vectorizer.pkl', 'rb'))


# Define a function to predict the email category with confidence
def predict_email_category_with_confidence(email_text):
    # Vectorize the input email text using the saved vectorizer
    email_vectorized = vectorizer.transform([email_text])

    # Predict using the trained model and get confidence (probabilities)
    prediction = model.predict(email_vectorized)
    max_confidence = np.max(model.predict_proba(email_vectorized)) * 100  # Get the highest confidence

    # Map the prediction to the corresponding category
    if prediction == 0:
        email_category = "Good"
    elif prediction == 1:
        email_category = "Spam"
    else:
        email_category = "Phishing"

    return email_category, max_confidence


# Function to take user input for raw email content
def get_raw_email_content():
    print("\n📥 Paste full raw email content below (press Enter twice to finish):")
    raw_lines = []
    while True:
        line = input()
        if line.strip() == "":
            break
        raw_lines.append(line)
    raw_email = "\n".join(raw_lines)
    return raw_email


# Get the raw email content from the user
raw_email = get_raw_email_content()

# Predict the category and confidence of the email
email_category, confidence = predict_email_category_with_confidence(raw_email)

# Display the prediction and confidence
print(f"\n🔮 Prediction: {email_category.upper()} (Confidence: {confidence:.2f}%)")
