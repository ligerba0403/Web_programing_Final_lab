<?php
/**
 * Shared project form fields (used by add & edit)
 * Expects $data array to be set in parent scope.
 */
$categories = ['Web', 'API', 'Mobile', 'Desktop', 'Other'];
?>

<!-- Language Tabs -->
<div class="lang-tabs" id="langTabs">
  <button type="button" class="lang-tab active" data-lang="tr">
    <i data-lucide="flag"></i> Türkçe
  </button>
  <button type="button" class="lang-tab" data-lang="en">
    <i data-lucide="globe"></i> English
  </button>
</div>

<div class="form-grid">

  <!-- TR Fields -->
  <div class="form-group form-group--full lang-panel lang-panel--tr">
    <label for="title">Proje Başlığı (TR) *</label>
    <input type="text" id="title" name="title"
           placeholder="Türkçe başlık"
           value="<?= htmlspecialchars($data['title'] ?? '') ?>" required />
  </div>

  <div class="form-group form-group--full lang-panel lang-panel--tr">
    <label for="description">Açıklama (TR) *</label>
    <textarea id="description" name="description" rows="4"
              placeholder="Türkçe açıklama..." required><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
  </div>

  <!-- EN Fields -->
  <div class="form-group form-group--full lang-panel lang-panel--en" style="display:none">
    <label for="title_en">Project Title (EN) *</label>
    <input type="text" id="title_en" name="title_en"
           placeholder="English title"
           value="<?= htmlspecialchars($data['title_en'] ?? '') ?>" />
  </div>

  <div class="form-group form-group--full lang-panel lang-panel--en" style="display:none">
    <label for="description_en">Description (EN) *</label>
    <textarea id="description_en" name="description_en" rows="4"
              placeholder="English description..."><?= htmlspecialchars($data['description_en'] ?? '') ?></textarea>
  </div>

  <!-- Common Fields -->
  <div class="form-group">
    <label for="technologies">Technologies * <small>(comma separated)</small></label>
    <input type="text" id="technologies" name="technologies"
           placeholder="PHP, MySQL, JS"
           value="<?= htmlspecialchars($data['technologies'] ?? '') ?>" required />
  </div>

  <div class="form-group">
    <label for="category">Category</label>
    <select id="category" name="category">
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat ?>" <?= ($data['category'] ?? 'Web') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group form-group--full">
    <label for="image_url">Image URL</label>
    <input type="url" id="image_url" name="image_url"
           placeholder="https://..."
           value="<?= htmlspecialchars($data['image_url'] ?? '') ?>" />
  </div>

  <div class="form-group">
    <label for="project_url">Demo URL</label>
    <input type="url" id="project_url" name="project_url"
           placeholder="https://..."
           value="<?= htmlspecialchars($data['project_url'] ?? '') ?>" />
  </div>

  <div class="form-group">
    <label for="github_url">GitHub URL</label>
    <input type="url" id="github_url" name="github_url"
           placeholder="https://github.com/..."
           value="<?= htmlspecialchars($data['github_url'] ?? '') ?>" />
  </div>

  <div class="form-group">
    <label for="sort_order">Sort Order</label>
    <input type="number" id="sort_order" name="sort_order" min="0"
           value="<?= (int)($data['sort_order'] ?? 0) ?>" />
  </div>

  <div class="form-group form-check-group">
    <input type="checkbox" id="is_featured" name="is_featured" value="1"
           <?= !empty($data['is_featured']) ? 'checked' : '' ?> />
    <label for="is_featured">Featured Project</label>
  </div>

</div>
