# Cam4Park

Requète POST (API Token dans header HTPP_AUTHORIZATION) :

Token dans table Device

 

{
  "plate":"??-###-??",
  "date":"Y-m-d H:i:s",
  "way":"entry|exit|undetermined"
}

Réponse attendue :
{
  "httpStatusCode":201,
  "authorized":"authorized|unauthorized"
}


curl -X 'POST'   'http://192.168.122.202:8080/movement'   -H 'accept: application/json'   -H 'http-authorization: NDRkZDdlNzJiMjYyZTlkZTAyMjYzYWI3ZDViMTIzYzI4MmFmNTFhOTU0YTUyMTJkMTY1MzMxNzA4OA=='   -H 'Content-Type: application/json'   -d '{
  "plate": "HD-777-HK",
  "date": "2022-06-21 23:58:00",
  "way": "entry"
}'

curl -X 'GET'   'http://192.168.122.202:8080/remaining_place'   -H 'accept: application/json'   -H 'Content-Type: application/json'
