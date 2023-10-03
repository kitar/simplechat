## Simplechat

An example chat app to illustrate the usage of [kitar/laravel-dynamodb](https://github.com/kitar/laravel-dynamodb).

![demo](https://github.com/kitar/simplechat/assets/157844/dba7753a-4db7-4f90-b7bf-4a990e3d3532)

### Create a DynamoDB table

Create a DynamoDB table (it's a single table) with the following conditions:

- Partition key: `PK` (string)
- Sort key: `SK` (string)
- Global secondary indexes
    - GSI1
        - Index name: `GSI1`
        - Partition key: `GSI1PK` (string)
        - Sort key: `GSI1SK` (string)
    - GSI2
        - Index name: `GSI2`
        - Partition key: `GSI2PK` (string)
        - Sort key: `GSI2SK` (string)

Create IAM for interacting with DynamoDB. The policy will be like below:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "dynamodb:GetItem",
                "dynamodb:PutItem",
                "dynamodb:UpdateItem",
                "dynamodb:DeleteItem",
                "dynamodb:Scan",
                "dynamodb:Query"
            ],
            "Resource": [
                "arn:aws:dynamodb:ap-northeast-1:705561772438:table/your-table-name",
                "arn:aws:dynamodb:ap-northeast-1:705561772438:table/your-table-name/index/*"
            ]
        }
    ]
}
```

### Installing the project

Clone the repo locally:

```
git clone https://github.com/kitar/simplechat.git simplechat
cd simplechat
```

Setup configuration:

```
cp .env.example .env
```

Open `.env` file and configure the `DB_DEFAULT_TABLE` and `AWS_*`.

- `DB_DEFAULT_TABLE` DynamoDB table name you've created.
- `AWS_ACCESS_KEY_ID`
- `AWS_SECRET_ACCESS_KEY`
- `AWS_DEFAULT_REGION`

Install PHP dependencies:

```
composer install
```

Install NPM dependencies:

```
npm install
```

Build assets:

```
npm run dev
```

Generate application key:

```
php artisan key:generate
```

Run the dev server (the output will give the address):

```
php artisan serve
```

### Installing soketi

Install:

```
npm install -g @soketi/soketi@latest
```

Open a new terminal window and let it run in the background:

```
soketi start
```

### That's it!

Now you can visit `http://127.0.0.1:8000` with your browser, create a chat room, and start chatting.

You can use the following artisan commands to manage the data.

- `user:list`
- `user:delete {uuid} {--with-data}`
- `room:list {--user=}`
- `room:delete {roomId}`
- `message:list {--room=} {--user=}`

### Built with awesome tools

- [Laravel](https://laravel.com/)
- [DynamoDB](https://aws.amazon.com/dynamodb/)
- [Soketi](https://soketi.app/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Tailwind UI](https://tailwindui.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Trix](https://trix-editor.org/)
- and more...
