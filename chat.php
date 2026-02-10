<div id="faic-float-btn" onclick="faic_toggle()">
  💬
  <span id="faic-online-dot"></span>
</div>

<div id="faic-widget">
  <div id="faic-header">Get In Touch</div>

  <div id="faic-messages"></div>

  <input id="faic-name" name="name" placeholder="Your Name">
  <input id="faic-email" name="email" type="email" placeholder="Your Email">
  <input id="faic-phone" name="phone" placeholder="Your Phone">

  <select id="faic-region" name="region">
    <option value="">Select Your Region</option>
    <option value="USA">USA</option>
    <option value="Canada">Canada</option>
    <option value="Europe">Europe</option>
    <option value="Asia">Asia</option>
    <option value="Middle East">Middle East</option>
    <option value="Rest of World">Rest of World</option>
  </select>

  <textarea id="faic-input" name="project" placeholder="Project Details"></textarea>

  <button type="button" onclick="faic_send()">Submit</button>
</div>
