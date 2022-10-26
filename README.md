# API documentation
Your customers can write content with our AI-powered content generation API. They can write emails, blog posts, social media posts and more, in various languages and tones!

## Pricing
| Characters | Price |
| --- | --- |
| 0-10k | Free |
| 10k-1M | $0.75/10k characters |
| 1M-10M | $0.70/10k characters |
| 10M-100M | $0.65/10k characters |
| >100M | $0.60/10k characters |

Your card will be billed for usage worth of every $100.

## API key
Head over to [Accounts → API](https://app.rytr.me/account/api-access) section and get the API key.

## API endpoints

### Language list
Get list of languages
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -X GET https://api.rytr.me/v1/languages
```

### Tone list
Get list of tones
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -X GET https://api.rytr.me/v1/tones
```

### Use-case list
Get list of use-case
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -X GET https://api.rytr.me/v1/use-cases
```

### Use-case detail
Get detail of particular use-case
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -X GET https://api.rytr.me/v1/use-cases/<USE-CASE ID>
```

### Ryte
Generate content using AI
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -d '{"languageId": "<LANUGAGE ID>", "toneId": "<TONE ID>", "useCaseId": "<USE-CASE ID>", "inputContexts": {"<USE-CASE CONTEXT-INPUT KEY-LABEL>": "<VALUE>"}, "variations": 1, "userId": "<UNIQUE USER ID>", "format": "html", "creativityLevel": "default"}' \
  -X POST https://api.rytr.me/v1/ryte
```
Supported formats `format` = `html` | `text`

Supported creativity levels `creativityLevel` = `default` | `none` | `low` | `medium` | `high` | `max`

You can request upto maximum 3 variants per request, i.e. `variations` = 1 to 3

For `userId` you need to supply user ID from your database, eg: primary key for `users` database table. As a consumer of Rytr API, we assume you have a product/service yourself with user and since they'll be exposed to the Rytr API via your service, we need to track a unique key for each user from your database. It doesn't necessarily need to be a primary key, it can be any unique key generated for each user.

### Usage
Get usage for current billing period
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -X GET https://api.rytr.me/v1/usage
```

### Custom use case create
Create [custom use-case](https://rytr.me/resources#custom-use-cases) and submit for approval.
```bash
curl \
  -H "Authentication: Bearer <API KEY>" \
  -H "Content-Type: application/json" \
  -d '{"name": "<NAME>", "inputName": "<INPUT NAME>", "inputPlaceholder": "<INPUT PLACEHOLDER>", "outputExample": "<OUTPUT EXAMPLE>"}' \
  -X POST https://api.rytr.me/v1/custom-use-cases/create
```
