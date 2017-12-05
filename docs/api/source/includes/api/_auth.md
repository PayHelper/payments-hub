# Authentication

> Obtaining a JWT token:

```shell
curl -X POST \
  https://localhost/api/v1/login_check \
  -H 'content-type: application/json' \
  -d '{
    "username":"admin",
    "password":"admin"
}
'
```

Payments Hub allow you to authenticate using [Json Web Tokens](https://jwt.io) (JWT).
This guide will take you through the steps of authenticating using JWT (obtaining token etc.).


<aside class="notice">There is default admin account created for now with username "admin" and password "admin" which can be used to authenticate.</aside>

> Example Response 

```json
{"token":"eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX0FETUlOIl0sInVzZXJuYW1lIjoiYWRtaW4iLCJpYXQiOjE1MDA0NTUzNTEsImV4cCI6MTUwMDQ1ODk1MX0.cmJFi_M_bmQnjS4VdP4eKdZYvury8i4wX6Rzn5psehG6Pg8X8Z2N-GKSn_ugXPTEs2KiUxLQ1hC3FMSioxe-OfaOX0thMRiU89MK-jDv52h-vAoVBnjd60vB5oxSdtVy3rXTJOyx99aULurrUCbVAX4FIIKbGPczhVL7kTuBmXihPT2jl65vQnvnAo7HWJZgc9ZAG0l6pVV9YnRqBmB2ht70ce8hYjQAwc-UzzGqJipQL7uWNytx-Dol07zM00YapBt9UgmeBpj79iIC7XSkMVAWNBFLhV6UAaafOWJBa55z6JgbdrescXgbHMFcnqGpUECOetLhfqZAyoSyGz7igXViRcFXB2Vgg2TKzYL1Ok3pQojQV5g1GXSX27H5URFihJf5Aeeloo014xVJzJmM2UOo6JM00YIlPLMP3AaRbUNMKmMNZhJzwkyqVn_AArOdt4QkFB_9ImK4VTw7K6USrLYBKkFBtbIByjt0ooUIxYwSz8Ofy7TgFkGdI-7TT3egzT6bwQ5u6ZRKd6C8PP_VITEJKD8GjFmi5PodikrMiq2FzN3KCvSGl5i_7AN0_OH8A4tHZ22_5ZICWaVGWZCYGE-zbNQ7k6nyezK0Bxu49mJAayzH_NCpiydjDixC81o29TRf2qr3ZpXsPoiF1AXlE_RoAKk3cARgI8CPW6-bsjc"}
```

This endpoint will return a json response with the token.

> To authorize, use this code:

```shell
curl -X GET \
  https://localhost/api/v1/subscriptions/
   -H "Authorization: Bearer key"\
  -H 'content-type: application/json'
'
```

`Authorization` header (bearer auth) must be passed to each request in order to authorize user.

> Make sure to replace `key` with your JWT token.
