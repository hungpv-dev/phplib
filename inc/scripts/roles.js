let route = '/api/roles';

let inputFilter = document.querySelector(".input-search");
inputFilter.addEventListener("input", function () {
  let value = this.value.toLowerCase();
  let listTextRole = document.querySelectorAll(".list-role");
  listTextRole.forEach(function (label) {
    let text = label.textContent.toLowerCase();
    var match = text.indexOf(value) > -1;
    if (match) {
      label.closest(".group-role").style.display = "flex";
    } else {
      label.closest(".group-role").style.display = "none";
    }
  });
});

// Handle Form
let formAdd = document.querySelector("#formAdd");
var modelAdd = document.querySelector("#addModel");
var closeAdd = formAdd.querySelector(".btn-close-model");
formAdd.addEventListener("submit", function (e) {
  e.preventDefault();

  // Loading btn
  let btn = this.querySelector("button[type=submit]");
  btnLoading(btn, true);

  let listData = formAdd.querySelectorAll(`[name="roles"]`);
  let value = [];

  listData.forEach((item) => {
    if (item.checked) {
      value.push(item.value);
    }
  });
  let id = document.getElementById("user-id").value;
  axios
    .put(`${route}/${id}`, value)
    .then((response) => {
      console.log(response);
      if (response.data.status == 200) {
        showMessageMD(response.data.successMessage);
      }else if(response.data.status == 403){
        showErrorMD(response.data.errorMessage);
      }
    })
    .finally(function () {
      btnLoading(btn, false);
    });
});
modelAdd.addEventListener("hidden.bs.modal", function (e) {
  clearAllClassValidate(formAdd);
});
