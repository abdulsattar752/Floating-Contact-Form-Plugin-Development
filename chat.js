function faic_toggle() {
  const widget = document.getElementById('faic-widget');
  widget.style.display = widget.style.display === 'flex' ? 'none' : 'flex';
}

document.addEventListener('DOMContentLoaded', function () {

  const phone = document.getElementById('faic-phone');
  if (phone) {
    phone.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '');
    });
  }

  window.faic_send = function () {

    const nameEl = document.getElementById('faic-name');
    const emailEl = document.getElementById('faic-email');
    const phoneEl = document.getElementById('faic-phone');
    const regionEl = document.getElementById('faic-region');
    const projectEl = document.getElementById('faic-input');
    const msg = document.getElementById('faic-messages');

    if (!nameEl || !emailEl || !phoneEl || !regionEl || !projectEl) {
      console.error('Elements missing');
      return;
    }

    if (!nameEl.value || !emailEl.value || !phoneEl.value || !regionEl.value || !projectEl.value) {
      msg.style.color = 'red';
      msg.innerText = 'Please fill all fields.';
      return;
    }

    msg.style.color = 'blue';
    msg.innerText = 'Submitting...';

    const data = new FormData();
    data.append('action', 'faic_submit_form');
    data.append('name', nameEl.value);
    data.append('email', emailEl.value);
    data.append('phone', phoneEl.value);
    data.append('region', regionEl.value);
    data.append('project', projectEl.value);

    fetch(faic_ajax.ajax_url, {
      method: 'POST',
      body: data
    })
      .then(r => r.json())
      .then(r => {
        if (r.success) {
          msg.style.color = 'green';
          msg.innerText = r.data;

          nameEl.value = '';
          emailEl.value = '';
          phoneEl.value = '';
          regionEl.value = '';
          projectEl.value = '';
        } else {
          msg.style.color = 'red';
          msg.innerText = r.data;
        }
      })
      .catch(() => {
        msg.style.color = 'red';
        msg.innerText = 'Submission failed. Try again.';
      });
  };

});
