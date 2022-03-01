document.addEventListener('DOMContentLoaded', e => {
  let note_form = document.forms.note;
  // initial request for all categories
  fetch(`${api}/categories`)
    .then(res => res.json())
    .then(json => {
      note_form.category_id.innerHTML = '<option>Select a category</option>';
      json.categories.forEach(category => {
        let opt = document.createElement('option');
        opt.value = category.id;
        opt.textContent = category.title;
        note_form.category_id.append(opt);
      });
    });
});