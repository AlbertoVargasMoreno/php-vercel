# php-app-vercel

[https://php-vercel-orcin-rho.vercel.app/app](https://php-vercel-orcin-rho.vercel.app/app)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![Vercel](https://img.shields.io/badge/Vercel-000000?style=for-the-badge&logo=vercel&logoColor=white)

Template repository to deploy PHP application to Vercel.

## My take on this

1. I followed first steps
2. Got errors due to runtime tag
3. Added a new function ![myapp.php](./api/myapp.php)
4. Could test function HTTP responses

## Important notes

- It was necessary to update the runtime tag, because in first Deployment attempt I got errors due to deprecated Node version
```
this was done through searching usage of runtime portion of vercel json
then in github, I decided to take the one with PHP8.1 to match my development environment
```

- For my custom script to be accessible, I updated the vercel.json to declare a new URI mapped to my added file

- After exploring the vercel interface, I found that each deployment is equivalent to each commit in master

- I research on options to have persistent data. 
```
Supabase. seems good, uses Postgres. but it is necessary to sign up, and set up. I wan't the less complex solution for this project

json file. I though could work. Even used it in local and seemed promising but at the end the vercel permissions restrict writing files

vercel blob. good. I could keep using the json file approach. But with PHP is not supported, it is only available for the native languages supported :C
```

- `cmdr` has issues with `CURL`
```
when I use CURL in cmdr to test a POST request, the app receives the body request as a string, but decoding it as json fails, and returns null.

I needed to use git-bash.exe included in the bin of laragon. Running a similar command works fine.

I don't have a clue on what changes must be done to the format
```

- Had Issues with reading file 'notes.json'. It seemed to be related with the path and the path from where It was invoked, the solution was to hardcode the absolute path in production

```bash
curl -X POST http://localhost:3000/api/myapp.php --data '{"comment": "I want to store this"}'

curl -X POST http://localhost:3000/api/myapp.php --data '{"comment": "whos there?"}'

curl -X POST https://php-vercel-orcin-rho.vercel.app/app --data '{"comment": "from local to prod"}'

```


## Structure 📂
```
php-app-vercel
├── .github
├── api
├── public
│   ├── images
│   ├── scripts
│   └── styles
├── .env.example
├── .gitignore
├── .vercelignore
├── LICENSE
├── README.md
├── composer.json
├── composer.lock
└── vercel.json
```
- [.github](.github/) is a folder that used to place Github related stuff, like CI pipeline.
- [api](api/) is a main folder that contains the PHP file.
- [public](public/) is a folder that contains the static files like images, scripts, and styles.
- [.env.example](.env.example) is a file that contains the environment variables used in this app.
- [.gitignore](.gitignore) is a file to exclude some folders and files from Git.
- [.vercelignore](.vercelignore) is a file to exclude some folders and files from Vercel.
- [LICENSE](LICENSE) is a file that contains the license used in this app.
- [README.md](README.md) is the file you are reading now.
- [composer.json](composer.json) is a file that contains the dependencies used and metadata in this app.
- [composer.lock](composer.lock) is a file that contains detailed list of all the dependencies and their specific versions that are currently installed in this app.
- [vercel.json](vercel.json) is a file that contains configuration and override the default behavior of Vercel.

## Installation 🛠️
- See [here](https://php-app-vercel.vercel.app/) for more information about installation and usage.

## References
- [Vercel Documentation](https://vercel.com/docs)
- [Vercel Community](https://github.com/vercel-community/php)
- [Vercel Examples](https://github.com/juicyfx/vercel-examples)
