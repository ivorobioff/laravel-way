https://github.com/restate/realestate-manuals/blob/master/Back-end/Installation.md

## Troubleshooting

##### Problem

```
[Composer\Downloader\TransportException]                                                                         
  The "https://api.github.com/repos/restate/shared-back-end" file could not be downloaded (HTTP/1.1 404 Not Found)
```

##### Solution

```
$ export GITHUB_ACCESS_TOKEN=hash-to-your-api-token
$ composer config -g github-oauth.github.com $GITHUB_ACCESS_TOKEN
$ composer install
```
