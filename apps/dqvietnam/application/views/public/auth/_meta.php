<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="theme-color" content="#ffffff">
<link rel="preconnect" href="https://unpkg.com">
<link rel="dns-prefetch" href="https://unpkg.com">
<meta content="<?= $this->security->get_csrf_hash() ?>" data-name="<?= $this->security->get_csrf_token_name() ?>" name="csrf-token">
<?php if (!empty($SEO)) : ?>
  <title><?php echo isset($SEO['meta_title']) ? $SEO['meta_title'] : ''; ?></title>
  <meta name="description" content="<?php echo isset($SEO['meta_description']) ? $SEO['meta_description'] : ''; ?>" />
  <meta name="keywords" content="<?php echo isset($SEO['meta_keyword']) ? $SEO['meta_keyword'] : ''; ?>" />
  <!--Meta Facebook Page Other-->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo isset($SEO['meta_title']) ? $SEO['meta_title'] : ''; ?>" />
  <meta property="og:description"
    content="<?php echo isset($SEO['meta_description']) ? $SEO['meta_description'] : ''; ?>" />
  <meta property="og:image" content="<?php echo isset($SEO['image']) ? $SEO['image'] : ''; ?>" />
  <meta property="og:image:alt"
    content="<?php echo isset($SEO['meta_description']) ? $SEO['meta_description'] : ''; ?>" />
  <meta property="thumbnail" content="<?php echo isset($SEO['image']) ? $SEO['image'] : ''; ?>" />
  <meta property="og:url" content="<?php echo current_url(); ?>" />
  <!--Meta Facebook Page Other-->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo isset($SEO['meta_title']) ? $SEO['meta_title'] : ''; ?>">
  <meta name="twitter:description" content="<?php echo isset($SEO['meta_description']) ? $SEO['meta_description'] : ''; ?>">
  <meta name="twitter:image" content="<?php echo isset($SEO['image']) ? $SEO['image'] : ''; ?>">
  <link rel="canonical" href="<?php echo isset($SEO['url']) ? $SEO['url'] : base_url(); ?>" />
<?php else : ?>
  <title><?php echo $this->settings['meta_name'] . ' - ' . $this->settings['meta_title']; ?></title>
  <meta name="description"
    content="<?php echo isset($this->settings['meta_desc']) ? $this->settings['meta_desc'] : ''; ?>" />
  <meta name="keywords"
    content="<?php echo isset($this->settings['meta_keyword']) ? $this->settings['meta_keyword'] : ''; ?>" />
  <!--Meta Facebook Homepage-->
  <meta property="og:type" content="website" />
  <meta property="og:title"
    content="<?php echo isset($this->settings['title']) ? $this->settings['title'] . ' | ' . $this->settings['name'] : ''; ?>" />
  <meta property="og:description"
    content="<?php echo isset($this->settings['meta_desc']) ? $this->settings['meta_desc'] : ''; ?>" />
  <meta property="og:image" content="<?= MEDIA_URL . ($this->settings['image_share_default'] ?? '') ?>" />
  <meta property="og:image:alt" content="<?php echo isset($this->settings['meta_desc']) ? $this->settings['meta_desc'] : ''; ?>" />
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo isset($this->settings['title']) ? $this->settings['title'] . ' | ' . $this->settings['name'] : ''; ?>">
  <meta name="twitter:description" content="<?php echo isset($this->settings['meta_desc']) ? $this->settings['meta_desc'] : ''; ?>">
  <meta name="twitter:image" content="<?= MEDIA_URL . ($this->settings['image_share_default'] ?? '') ?>">
  <meta property="thumbnail" content="<?= MEDIA_URL . ($this->settings['image_share_default'] ?? '') ?>" />
  <meta property="og:url" content="<?php echo current_url(); ?>" />
  <!--Meta Facebook Homepage-->
  <link rel="canonical" href="<?php echo base_url(); ?>" />
<?php endif; ?>
<link rel="icon"
  href="<?php echo !empty($this->settings['favicon']) ? getImageThumb($this->settings['favicon'], 32, 32) : base_url("public/favicon.ico"); ?>"
  sizes="32x32">
<link rel="icon"
  href="<?php echo !empty($this->settings['favicon']) ? getImageThumb($this->settings['favicon'], 192, 192) : base_url("public/favicon.ico"); ?>"
  sizes="192x192">
<link rel="apple-touch-icon-precomposed"
  href="<?php echo !empty($this->settings['favicon']) ? getImageThumb($this->settings['favicon'], 180, 180) : base_url("public/favicon.ico"); ?>">
<meta name="msapplication-TileImage"
  content="<?php echo !empty($this->settings['favicon']) ? getImageThumb($this->settings['favicon'], 270, 270) : base_url("public/favicon.ico"); ?>">