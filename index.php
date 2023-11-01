 <!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Chat Aristo - Chat GPT</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/main.css'>
</head>
<body>
<?php
// Chat GPT Api Keyi api.txt dosyası oluşturarak içerisine ekleyin. //
$api = file_get_contents('api.txt');
if((!empty($_POST['question']) && $_POST['ara'])) {
$question = $_POST['question'];
$question = json_encode($question);
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "model": "gpt-3.5-turbo",
  "messages": [
    {
      "role": "system",
      "content": "Your name is Aristoteless. You act and speak like a real person, not a robot or an assistant. You are an expert on every question you are asked. Your task is to answer questions as if they were your expertise"
    },
    {
      "role": "user",
      "content": '.$question.'
    }
  ],
  "temperature": 0.8,
  "max_tokens": 256,
  "top_p": 1,
  "frequency_penalty": 0,
  "presence_penalty": 0,
  "stop": [" Human:", " AI:"]
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$api,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response, true);
$reply = $response["choices"][0]["message"]["content"];
}else{
 $reply = "Soru Sorunuz...";
} ?>
<div class="bg text-center">
    <div class="container">
        <div class="centered">
        <p class="firstLine"> CHAT ARISTO</p>
        <p class="secondLine">"Aristo ile Düşün, Sor, Keşfet!"</p>
        <form method="POST">
            <p> 
              <input class="InputStyle" placeholder="Merakınızı Yazın..." value="<?php echo $_POST['question'];?>" autocomplete="off" name="question" type="text" require> 
              <small class="TextStyle">Örnek: Mutluluğun sırrı nedir?</small>
            </p>
            <button type="submit" name="ara" value="ara" class="btn btn-danger w-100 InputStyleBTN"> İlet</button>
        </form>
        <?php if((!empty($_POST['question']) && $_POST['ara'])) {?>
        <div class="clearfix"></div><br><br>
        <p class="bg-light w-100 p-3 text-dark InputStyleBTN"> <?php echo $reply;?> </p>
        <?php }?>
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='assets/js/bootstrap.min.js'></script>
</body>
</html>