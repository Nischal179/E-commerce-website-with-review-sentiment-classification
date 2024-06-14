from gradio_client import Client
def call_api(review="Tasted good"):
    client = Client("https://nischal69-sentiment-analyzer.hf.space/")
    result = client.predict(
				review,	# str representing input in 'review' Textbox component
				api_name="/predict"
)
    return(result)
call_api()
