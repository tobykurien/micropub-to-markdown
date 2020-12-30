Title: Post Content
Date: 2020-12-03 10:47
Author: Toby Kurien

<form name="postForm" role="form" action="https://yourdomain.com/micropub.php" method="post" class="well" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Re-post Article Title</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Article title">
  </div>
  <div class="form-group">
    <label for="repost-of">Re-post URL</label>
    <input type="text" class="form-control" id="repost-of" name="repost-of" placeholder="https://domain.com/article">
  </div>
  <div class="form-group">
    <label for="content">Content*</label>
    <textarea class="form-control" id="content" name="content" placeholder="Your microblog content" style="width:100%" rows="5" required></textarea>
  </div>
  <div class="form-group">
    <label for="published">Published date*</label>
    <input type="text" class="form-control" id="published" name="published">
  </div>
  <div class="form-group">
    <label for="category">Tags</label>
    <input type="text" class="form-control" id="category" name="category" placeholder="comma-separated list">
  </div>
  <div class="form-group">
    <label for="photo1">Photo 1</label>
    <input type="file" class="form-control" id="photo1" name="photo[]">
    <input type="text" class="form-control" id="alt1" name="mp-photo-alt[]" placeholder="Caption">
  </div>
  <div class="form-group">
    <label for="photo2">Photo 2</label>
    <input type="file" class="form-control" id="photo2" name="photo[]">
    <input type="text" class="form-control" id="alt1" name="mp-photo-alt[]" placeholder="Caption">
  </div>
  <div class="form-group">
    <label for="photo3">Photo 3</label>
    <input type="file" class="form-control" id="photo3" name="photo[]">
    <input type="text" class="form-control" id="alt1" name="mp-photo-alt[]" placeholder="Caption">
  </div>
  <div class="form-group">
    <label for="key">API Key*</label>
    <input type="password" class="form-control" id="key" name="key" placeholder="API key" required>
  </div>

  <input type="hidden" name="h" value="entry"/>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    document.forms["postForm"]["published"].value = (new Date()).toLocaleString();
</script>
