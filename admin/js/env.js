var env = {

    url: "http://localhost/PAGINAS/tagro_web/admin/",
  
};

function clearInputs(inputs) {
  inputs.each(function (e) {
    if (inputs[e].tagName.toLowerCase() == "input" || inputs[e].tagName.toLowerCase() == "textarea") {
      
      inputs[e].value = "";

    } else if (inputs[e].tagName.toLowerCase() == "select") {
      $(`#${inputs[e].id}`).val(0).trigger("change");
    }
  });
}