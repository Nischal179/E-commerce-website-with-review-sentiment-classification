import sys
from gradio_client import Client

def call_api(review):
    client = Client("https://nischal69-sentiment-analyzer.hf.space/")
    result = client.predict(review, api_name="/predict")
    return str(result)

# Check if the review argument is provided
if len(sys.argv) > 1:
    review = sys.argv[1]
else:
    review = "Tasted good"  # Default value
 
print(call_api(review))