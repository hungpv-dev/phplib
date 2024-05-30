var route = '/api/suppliers';

document.addEventListener("DOMContentLoaded", async function () {
  getData();
});

function getData(url = "",showAll = false) {
  let links = url == "" ? route : url;
  let searchValue = document.querySelector("#searchName").value.trim();
  let params = {}
  if(searchValue){
    params.search = searchValue;
  }
  if(showAll){
    params.show = true;
  }
  axios
    .get(links,{params})
    .then((response) => {
      console.log(response);
      if (response.data.status === 200) {
        showData(response.data.data);
      }else if(response.data.status === 403){
        showMessageMD(response.data.errorMessage);
      }
    });
}
function showData(response) {
  let data = response.data;
  
  // Load content
  let content = insertContent(data);
  
  // Tbody
  document.getElementById("data_table_body").innerHTML = content;
  // Loading
  document.querySelector(".loading-data").innerHTML = "";
  
  // Pagination
  let paginations = document.querySelector(".paginations");
  buildPagination(response, paginations, getData.name);
}

function insertContent(data){
  let content = data.map((item,index) => {
      return `
          <tr>
            <td class="username align-middle white-space-nowrap text-center">${index + 1}</td>
            <td class="username align-middle white-space-nowrap text-center"><a href="/quan-ly-nhan-vien/${item.user_id}">${item.user_id}</a></td>
            <td class="username align-middle white-space-nowrap text-center">${item.name}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.company}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.email}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.address}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.phone}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.type == 0 ? 'Vật liệu' : 'Dịch vụ'}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.status == 0 ? 'Hợp tác' : 'Ngưng hợp tác'}</td>
            <td class="align-middle white-space-nowrap text-center d-flex pe-0">
                <div class="position-relative">
                    <button onclick="showOne(${item.id})" class="btn btn-edit-show btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Sửa" type="button" data-bs-toggle="modal" data-bs-target="#editModel">
                        <span class="fas far fa-edit"></span>
                    </button>
                </div>
                <div class="position-relative">
                    <a href="/quan-ly-nha-cung-cap/cong-no/${item.id}" class="btn btn-edit-show btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Quản lý công nợ">
                      $
                    </a>
                </div>
            </td>
          </tr>
      `;
  }).join('');
  return content;
}

let showAll = document.querySelector("#show-all");
showAll.addEventListener('click',function(){
  if(this.dataset.id == 1){
    getData(url = "",true);
    this.dataset.id = 2;
    showAll.innerHTML = 'Rút gọn <<';
  }else{
    getData();
    this.dataset.id = 1;
    showAll.innerHTML = 'Xem tất cả >>';
  }
});

let formEdit = document.querySelector("#formEdit");
function showOne(id){
  axios.get(`${route}/${id}`)
  .then((response) => {
    if (response.data.status === 200) {
      let data = response.data.data;
      for(let name in data){
        let ele = formEdit.querySelector(`[name="${name}"]`);
        if(ele){
          ele.value = data[name];
        }
      }
      document.querySelector("#edit-id").value = data.id;
    }else if(response.data.status == 403){
      showErrorMD(response.data.errorMessage);
    }
  });
}

// // Handle Form
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
formSearch.addEventListener('submit',function(e){
  e.preventDefault();
  getData();
});



// Handle Form
let formAdd = document.querySelector("#formAdd");
var modelAdd = document.querySelector("#addModel");
var closeAdd = formAdd.querySelector(".btn-close-model");
formAdd.addEventListener('submit',function(e){
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
  if(check){
    // Loading btn
    let btn = this.querySelector("button[type=submit]");
    btnLoading(btn, true);

    let listData = [...formAdd.querySelectorAll(".data-value")];
    let data = listData.reduce((acc, item) => {
      acc[item.name] = item.value;
      return acc;
    }, {});
    axios
      .put(route, data)
      .then((response) => {
        if (response.data.status == 201) {
          closeAdd.click();
          showMessageMD(response.data.successMessage);
          getData();
        }else if(response.data.status == 403){
          closeAdd.click();
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
modelAdd.addEventListener("hidden.bs.modal", function (e) {
  clearAllClassValidate(formAdd);
});

