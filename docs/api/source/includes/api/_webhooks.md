# Webhooks

These endpoints will allow you to easily manage webhooks.

For example, imagine you want to send subscription's details to 3rd party application once the subscription has been created, or updated. Thanks to webhooks you can achieve it by creating a new webhook with the destination url to which the payload will be submitted.

## The webhook object

> Example Response

```json
{
    "id": 1,
    "url": "http://example.com/my-webhook",
    "created_at": "2017-06-28T13:01:17+0200",
    "updated_at": "2017-06-28T13:01:17+0200",
    "enabled": true,
    "_links": {
        "self": {
            "href": "/api/v1/webhooks/1"
        }
    }
}
```

Field | Type | Description
--------- | ------- | -------
id | integer | Unique identifier for the object.
url | string | The url to which the payload will be sent.
created_at | string | Time at which the object was created.
updated_at | string | Time at which the object was updated.
enabled | boolean | This boolean represents whether or not payment method is enabled or not.

## Create a webhook

> Definition

```shell
POST https://localhost/api/v1/webhooks/
```

Creates a new webhook object which is enabled by default.

> Example Request

```shell
curl -X POST \
  http://localhost/api/v1/webhooks/ \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
	"enabled": 1,
	"url": "http://example.com/my-webhook"
}'
```

> Example Response (201 Created)

```json
{
    "id": 1,
    "url": "http://example.com/my-webhook",
    "created_at": "2017-06-28T14:56:25+0200",
    "updated_at": "2017-06-28T14:56:25+0200",
    "enabled": true,
    "_links": {
        "self": {
            "href": "/api/v1/webhooks/3"
        }
    }
}
```

### Arguments

Name | Type | Description
--------- | ------- | -----------
url <br>(`required`)| string | The unique url of the webhook.
enabled <br>(`optional`)| boolean | Either 1 for enabled or 0 for disabled. Enabled is set to true by default.

### Returns

Returns a webhook if successfully created, and returns an error if something goes wrong.

## Retrieve a webhook

> Definition

```shell
GET https://localhost/api/v1/webhooks/{id}
```

Retrieves the details of an existing webhook. You need only supply the unique payment method code that was typed upon payment method creation.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/webhooks/1 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "id": 1,
    "url": "http://example.com/my-webhook",
    "created_at": "2017-06-28T14:56:25+0200",
    "updated_at": "2017-06-28T14:56:25+0200",
    "enabled": true,
    "_links": {
        "self": {
            "href": "/api/v1/webhooks/1"
        }
    }
}
```

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of the webhook.

### Returns

Returns a webhook if a valid identifier was provided, and returns an error otherwise.

## Update a webhook

> Definition

```shell
PATCH https://localhost/api/v1/webhooks/{id}
```

Updates already existing webhook object.

> Example Request

```shell
curl -X PATCH \
  http://localhost/api/v1/webhooks/1 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
	"enabled": 1,
	"url": "http://edit-example.com/my-webhook"
}'
```

> Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of the webhook.
url <br>(`required`)| string | The unique url of the webhook.
enabled <br>(`optional`)| boolean | Either 1 for enabled or 0 for disabled. Enabled is set to true by default.

### Returns

Returns an empty response if a valid identifier was provided, and returns an error otherwise.

## Delete a webhook

> Definition

```shell
DELETE https://localhost/api/v1/webhooks/{id}
```

Deletes a webhook object. You need only supply the unique webhook identifier that was generated upon subscription creation in order to remove webhook.

> Example Request

```shell
curl -X DELETE \
  http://localhost/api/v1/webhook/1 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of a webhook.

### Returns

Returns an empty response if deleting a webhook succeeded. Returns an error if deleting a webhook can not be done (e.g. when the webhook does not exist).

## List all webhooks

> Definition

```shell
GET https://localhost/api/v1/webhooks/
```

Returns a list of all webhooks.

> Example Request

```shell
curl -X GET \
  https://localhost/api/v1/webhooks/
   -H "Authorization: Bearer key"\
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "page": 1,
    "limit": 10,
    "pages": 1,
    "total": 2,
    "_links": {
        "self": {
            "href": "/api/v1/webhooks/?page=1&limit=10"
        },
        "first": {
            "href": "/api/v1/webhooks/?page=1&limit=10"
        },
        "last": {
            "href": "/api/v1/webhooks/?page=1&limit=10"
        }
    },
    "_embedded": {
        "items": [
            {
                "id": 1,
                "url": "http://example.com/hook1",
                "created_at": "2017-06-28T13:01:17+0200",
                "updated_at": "2017-06-28T13:01:17+0200",
                "enabled": true,
                "_links": {
                    "self": {
                        "href": "/api/v1/webhooks/1"
                    }
                }
            },
            {
                "id": 3,
                "url": "http://example.com/hook2",
                "created_at": "2017-06-28T14:56:25+0200",
                "updated_at": "2017-06-28T14:56:25+0200",
                "enabled": true,
                "_links": {
                    "self": {
                        "href": "/api/v1/webhooks/3"
                    }
                }
            }
        ]
    }
}
```

### Arguments

Argument | Default | Description
--------- | ------- | -----------
limit | 10 | A limit on the number of objects to be returned.
page | 1 | A page number

### Returns

A dictionary with a `items` property that contains an array of up to `limit` webhooks. Each entry in the array is a separate webhook object. If no more webhooks are available, the resulting array will be empty. This request should never return an error.
