var route = "/api/products";

document.addEventListener("DOMContentLoaded", async function () {
  getData();
});

function getData(url = "") {
  let links = url == "" ? route : url;
  let searchValue = document.querySelector("#searchName").value.trim();
  let filterId = document.querySelector("#filterId").value;
  let params = {};
  if (searchValue) {
    params.search = searchValue;
  }
  params.filter = filterId;
  axios.get(links, { params }).then((response) => {
    if (response.data.status === 200) {
      showData(response.data.data);
    } else if (response.data.status === 403) {
      showMessageMD(response.data.errorMessage);
    }
  });
}

function showData(response) {
  let data = response.data;

  // Load content
  let heading = insertHeading();
  let content = insertContent(data);

  // Heading
  document.getElementById("tr-render").innerHTML = heading;
  // Tbody
  document.getElementById("data_table_body").innerHTML = content;
  // Loading
  document.querySelector(".loading-data").innerHTML = "";

  // Pagination
  let paginations = document.querySelector(".paginations");
  buildPagination2(response, paginations, getData.name);
}

function insertContent(data) {
  let filterId = document.querySelector("#filterId").value;
  let content = data
    .map((item, index) => {
      let content = `
      <tr>
        <td class="username align-middle white-space-nowrap text-center">${
          index + 1
        }</td>
        <td class="username align-middle white-space-nowrap text-center">${
          item.name
        }</td>
        <td class="username align-middle white-space-nowrap text-center">${formatMoney(
          item.price
        )}</td>`;

        if(filterId == 1){
          content += `
          <td class="username align-middle white-space-nowrap text-center">${item.grade_id}</td>
          <td class="username align-middle white-space-nowrap text-center">${item.sand_id}</td>
          <td class="username align-middle white-space-nowrap text-center">${item.cement_id}</td>
          <td class="username align-middle white-space-nowrap text-center">${item.additives_id}</td>
          <td class="username align-middle white-space-nowrap text-center">${item.slump_id}</td>`;
        }
      
      content += `
        <td class="username align-middle white-space-nowrap text-center">${item.u_name}</td>
        <td class="username align-middle white-space-nowrap text-center">${item.c_name}</td>
        <td class="username align-middle white-space-nowrap text-center">${item.desc}</td>
        <td class="username align-middle white-space-nowrap text-center">${item.updated_at}</td>
        <td class="username align-middle white-space-nowrap text-center">${item.created_at}</td>
        <td class="align-middle white-space-nowrap text-center d-flex pe-0">
            <div class="position-relative">
                <button onclick="showOne(${item.id})" class="btn btn-edit-show btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Sửa" type="button" data-bs-toggle="modal" data-bs-target="#editModel">
                    <span class="fas far fa-edit"></span>
                </button>
            </div>
        </td>
      </tr>
  `;
      return content;
    })
    .join("");
  return content;
}

function insertHeading(){
  let filterId = document.querySelector("#filterId").value;
  let content = `
    <th class="sort align-middle text-center" scope="col" style="max-width:60px">#</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Tên</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Giá</th>
  `;
  if(filterId == 1){
    content += `
    <th class="sort align-middle text-center" scope="col" style="max-width: 200px">Mã bê tông</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Mã cát</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Mã xi măng</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Mã phụ gia</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Mã độ sụt</th>
  `;
  }
  content += `
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Đơn vị tính</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Loại hình</th>
    <th class="sort align-middle text-center" scope="col" style="max-width:160px">Mô tả</th>
    <th class="sort align-middle text-center" scope="col" style="max-width: 200px">Ngày cập nhật</th>
    <th class="sort align-middle text-center" scope="col" style="max-width: 200px">Ngày tạo</th>
    <th class="sort align-middle text-center" scope="col">Hành động</th>
  `;
  return content;
}

let filterId = document.querySelector("#filterId");
filterId.addEventListener("change", function () {
  getData();
});

let contentFormEdit = document.querySelector("#content-form-edit").innerHTML;
let formEdit = document.querySelector("#formEdit");
function showOne(id) {
  let filterId = document.querySelector("#filterId").value;
  axios.get(`${route}/${id}`).then((response) => {
    if (response.data.status === 200) {
      let data = response.data.data;
      if(filterId == 2){
        document.querySelector("#content-form-edit").innerHTML = "";
      }else{
        document.querySelector("#content-form-edit").innerHTML = contentFormEdit;
      }
      for (let name in data) {
        let ele = formEdit.querySelector(`[name="${name}"]`);
        if (ele) {
          ele.value = data[name];
        }
      }
      document.querySelector("#edit-id").value = data.id;
    } else if (response.data.status == 403) {
      showErrorMD(response.data.errorMessage);
    }
  });
}

// Handle Form
var modelEdit = document.querySelector("#editModel");
var closeEdit = formEdit.querySelector(".btn-close-model");
formEdit.addEventListener('submit',function(e){
  e.preventDefault();
    // Validator
  let elementValidator = formEdit.querySelectorAll(".data-validate");
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
  if(check){
    // Loading btn
    let btn = this.querySelector("button[type=submit]");
    btnLoading(btn, true);

    let listData = [...formEdit.querySelectorAll(".data-value")];
    let data = listData.reduce((acc, item) => {
      acc[item.name] = item.value;
      return acc;
    }, {});
    let id = document.querySelector("#edit-id").value;
    data.price = removeCommas(data.price);
    axios
      .put(`${route}/${id}`, data)
      .then((response) => {
        if (response.data.status == 200) {
          closeEdit.click();
          showMessageMD(response.data.successMessage);
          getData();
        }else if(response.data.status == 403){
          closeEdit.click();
          showErrorMD(response.data.errorMessage);
        }else if(response.data.status == 422){
          let errors = response.data.data;
          for(err in errors){
            alert(errors[err]);
          }
        }
      })
      .finally(function () {
        btnLoading(btn, false);
      });
  }
});
modelEdit.addEventListener("hidden.bs.modal", function (e) {
  clearAllClassValidate(formEdit);
});

// Tìm kiếm
let formSearch = document.querySelector("#form-search");
formSearch.addEventListener("submit", function (e) {
  e.preventDefault();
  getData();
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
    data.price = removeCommas(data.price);
    axios
      .put(route, data)
      .then((response) => {
        console.log(response);
        if (response.data.status == 201) {
          closeAdd.click();
          showMessageMD(response.data.successMessage);
          getData();
        } else if (response.data.status == 403) {
          closeAdd.click();
          showErrorMD(response.data.errorMessage);
        } else if (response.data.status == 422) {
          let errors = response.data.data;
          for (err in errors) {
            alert(errors[err]);
          }
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

let selectCategory = document.querySelector("#category_id");
let contentFormAdd = document.querySelector("#content-form-add").innerHTML;
document.querySelector("#content-form-add").innerHTML = "";

selectCategory.addEventListener("change", function () {
  let id = this.value;
  let content = "";
  if (id != 2) {
    content = contentFormAdd;
  } else {
    content = "";
  }
  document.getElementById("content-form-add").innerHTML = content;
});
