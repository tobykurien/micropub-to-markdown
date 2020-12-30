# micropub-to-markdown

IndieWeb scripts for publishing using micropub to a static-site generator like Pelican. The scripts in this repo allow you to quickly setup a system where you can post directly to your static-site by using a mobile app like [Indigenous](https://indieweb.org/indigenous), or using the [included web form](src/post-content.md). You can also then syndicate your posts to Twitter or Mastodon via [Brid.gy](https://brid.gy) by using the included [syndication form](src/syndicate-content.md).

Uploaded images are automatically resized and stripped of metadata using the `mogrify` utility.

The markdown front matter is using the format used by Pelican, but can be easily changed by modifying the `src/micropub.php` file.

# Installation

- Clone this repo to your hosting server
- At the top of each file in `script` and also `src/micropub.php` there is a config section that will need to be edited to match your server paths, user, etc. Modify as needed (also the paths in `setup.sh`).
- Run `scripts/setup.sh` to install the needed dependencies and create the directory where the uploaded files are stored.
- Copy the files in `src` to the Pelican (or other generator) content folder. It should be set up to copy the php script into your web root.
- Generate and publish your blog. If setup correctly, you can call `scripts/publish.sh` which will check for any new uploaded posts, import them, resize image and strip them of metadata, commit everything into git, generate your site, and then publish it back into your web root.
- Run `nohup scripts/service.sh &` to watch for new uploads and trigger the publish routine.

# Usage

Once installed, you can publish posts from your mobile device using [Indigenous](https://indieweb.org/indigenous). Under accounts, set your post endpoint to `https://yourdomain.com/micropub.php?key=yyourAPIkey`.

You can also publish directly from your website by using a web browser, simply load the `post-content` generated page, fill in the form and submit. A few seconds later your post should appear on your site if everything is setup correctly.

Finally, if you'd like to syndicate your content to Twitter/Mastodon/etc, load the `syndicate-content` generated page and paste in the URL of your post and click the relevant button. You will need to have linked your Twitter/Mastodon account beforehand on [Brid.gy](https://brid.gy), and also make sure your generated posts have this somewhere in the content (which can be setup in your article template) to allow brid.gy to cross-post your article:

```
    <a href="https://brid.gy/publish/mastodon"></a>
    <a href="https://brid.gy/publish/twitter"></a>
```

# Example

An example of a microblog using this: [https://tobykurien.com/category/microblog/]()