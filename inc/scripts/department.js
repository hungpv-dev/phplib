var route = "/api/departments";

let listBtnDelete = document.querySelectorAll(".btn-delete");
listBtnDelete.forEach((item) => {
  item.addEventListener("click", function (event) {
    if (confirm("Xóa user khỏi phòng ban")) {
      let btn = event.currentTarget;
      let id = btn.dataset.id;
      axios.delete(`${route}/${id}`).then((response) => {
        if (response.data.status == 204) {
          btn.closest("tr").remove();
          showMessageMD("Đã xóa user khỏi phòng ban thành công");
        }
      });
    }
  });
});

// Handle Form
let formAdd = document.querySelector("#formAdd");
var modelAdd = document.querySelector("#addModel");
var closeAdd = formAdd.querySelector(".btn-close-model");
formAdd.addEventListener("submit", function (e) {
  e.preventDefault();
  // Validator
  let elementValidator = formAdd.querySelectorAll(".data-validate");
  let check = true;
  elementValidator.forEach(function (item) {
    let test;
    if (item.tagName.toLowerCase() === "select") {
      test = validateSelectOption(item, item.title);
    } else {
      test = validateNotEmpty(item);
    }
    if (!test) check = false;
  });
  if (check) {
    // Loading btn
    let btn = this.querySelector("button[type=submit]");
    btnLoading(btn, true);

    let listData = [...formAdd.querySelectorAll(".data-value")];
    let data = listData.reduce((acc, item) => {
      acc[item.name] = item.value;
      return acc;
    }, {});
    axios
      .put(`${route}/${data.department_id}`, data)
      .then((response) => {
        console.log(response);
        if (response.data.status == 200) {
          let user = response.data.data;
          let ele = document.querySelector(`.tr-clost-${user.id}`);
          if (ele) {
            ele.remove();
          } else {
            let id = document.getElementById("department-id").value;
            if (parseInt(user.department_id) == id) {
              let content = `
              <tr class="tr-clost-${user.id}">
                <td>${user.id}</td>
                <td><a href="/quan-ly-nhan-vien/${user.id}">${
                user.name
              }</a></td>
                <td>${user.email}</td>
                <td>${user.status == 0 ? "Hoạt động" : "Ngưng hoạt động"}</td>
                <td>
                    <div class="position-relative">
                        <button data-id="${
                          user.id
                        }" class="btn btn-delete btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Xóa khỏi phòng ban" type="button">
                            <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path></svg>
                        </button>
                    </div>
                  </td>
              </tr>
            `;
              document
                .getElementById("data_table_body")
                .insertAdjacentHTML("beforeend", content);
            }
          }
          closeAdd.click();
          showMessageMD(response.data.successMessage);
        } else if (response.data.status == 403) {
          closeAdd.click();
          showErrorMD(response.data.errorMessage);
        }
      })
      .finally(function () {
        btnLoading(btn, false);
      });
  }
});
modelAdd.addEventListener("hidden.bs.modal", function (e) {
  clearAllClassValidate(formAdd);
});
