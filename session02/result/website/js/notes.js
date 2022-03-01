const api = 'http://localhost:81';
var notes_ul, note_form, menu_form;

const clear_form = form => {
  // clear all visible form fields
  form.reset();
  // remember to rest all the hidden fields as well...
  form.querySelectorAll('[type="hidden"]').forEach(elm => elm.value = '');
  // hide elements that has the "hide" class name
  form.querySelectorAll('.hide').forEach(elm => elm.classList.add('hidden'));
};

const onclick_notes_ul = e => {
  e.preventDefault();
  if(e.target.nodeName == 'A'){
    let id = e.target.getAttribute('href');
    fetch(`${api}/notes/${id}`)
      .then(res => res.json())
      .then(json => {
        let note = json.note;
        // Add note values to the form
        note_form.id.value = note.id;
        note_form.title.value = note.title;
        note_form.content.value = note.content;
        note_form.category_id.value = note.category_id;
        note_form.delete.classList.remove('hidden');
      });
  }
};

const onsubmit_note_form = e => {
  e.preventDefault();
  switch(e.submitter.name){
    case 'save':
      // a note object based on the form values
      let note = {};
      note.title = e.target.title.value;
      note.content = e.target.content.value;
      note.category_id = e.target.category_id.value;
      // url and method for posting a new note
      let url = `${api}/notes`;
      let method = 'POST';
      // if id has a value we are updating a note
      if(e.target.id.value){
        url += `/${e.target.id.value}`;
        method = 'PUT';
        note.id = e.target.id.value;
      }
      let request = new Request(url, {
        method: method,
        mode: 'cors',
        headers: {
          'Content-Type':'application/json'
        },
        body: JSON.stringify(note)
      });
      fetch(request)
        .then(res => res.json())
        .then(json => {
          if(request.method == 'PUT'){
            // this is a PUT request for updating a note
            let a = notes_ul.querySelector(`a[href="${json.note.id}"]`);
            a.textContent = json.note.title;
          }else{
            // this is a POST request for creating a new note
            // Add the note to the list
            let li = document.createElement('li');
            let a = document.createElement('a');
            a.href = json.note.id;
            a.textContent = json.note.title;
            li.append(a);
            notes_ul.append(li);
          }
          clear_form(note_form);
        });
      break;
    case 'delete':
      if(e.target.id.value){
        let request = new Request(`${api}/notes/${e.target.id.value}`, {
          method: 'DELETE',
          mode: 'cors'
        });
        fetch(request)
          .then(res => res.json())
          .then(json => {
            // remove the note from the list
            let a = notes_ul.querySelector(`a[href="${json.id}"]`);
            let li = a.closest('li');
            li.outerHTML = '';
            clear_form(note_form);
          });
      }
      break;
  }
};

const onsubmit_menu_form = e => {
  console.log(e.submitter);
  e.preventDefault();
  switch(e.submitter.name){
    case 'new':
      clear_form(note_form);
      break;
  }
};

document.addEventListener('DOMContentLoaded', e => {
  notes_ul = document.getElementById('notes');
  note_form = document.forms.note;
  menu_form = document.forms.menu;
  // initial request for all notes
  fetch(`${api}/notes`)
    .then(res => res.json())
    .then(json => {
      notes_ul.innerHTML = '';
      json.notes.forEach(note => {
        let li = document.createElement('li');
        let a = document.createElement('a');
        a.href = note.id;
        a.textContent = note.title;
        li.append(a);
        notes_ul.append(li);
      });
    });
  // event listers for the UI
  notes_ul.addEventListener('click', onclick_notes_ul);
  note_form.addEventListener('submit', onsubmit_note_form);
  menu_form.addEventListener('submit', onsubmit_menu_form);
});