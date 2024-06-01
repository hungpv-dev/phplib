var route = '/api/quote_details';
var routeDetail = '/api/quote_detail';

document.addEventListener("DOMContentLoaded", async function () {
  getData();
});
function getData(url = "") {
  let id = document.querySelector("#data-id").value;
  let links = url == "" ? route+`/${id}` : url;
  let searchValue = document.querySelector("#searchName").value.trim();
  let params = {}
  if(searchValue){
    params.search = searchValue;
  }
  axios
    .get(links,{params})
    .then((response) => {
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
  buildPagination2(response, paginations, getData.name);
}

function insertContent(data){
  let content = data.map((item,index) => {
      return `
          <tr>
            <td class="username align-middle white-space-nowrap text-center">${index + 1}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.product_name +'(#'+item.product_id+')'}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.quantity}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.unit_name}</td>
            <td class="username align-middle white-space-nowrap text-center">${formatMoney(item.price)}</td>
            <td class="username align-middle white-space-nowrap text-center">${formatMoney(item.total)}</td>
            <td class="username align-middle white-space-nowrap text-center">${item.note || 'Không'}</td>
            <td class="align-middle white-space-nowrap text-center d-flex pe-0">
                <div class="position-relative">
                    <button onclick="showOne(${item.id})" class="btn btn-edit-show btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Sửa" type="button" data-bs-toggle="modal" data-bs-target="#editModel">
                        <span class="fas far fa-edit"></span>
                    </button>
                </div>
                <div class="position-relative">
                    <button onclick="confirmDelete('/api/quote_detail/${item.id}','Bạn chắc chắn muốn xóa chứ',getData)" class="btn btn-sm btn-phoenix-secondary text-info fs-10" title="Xóa" type="button" data-bs-toggle="modal">
                      <span class="nav-icons uil uil-trash"></span>
                    </button>
                </div>
            </td>
          </tr>
      `;
  }).join('');
  return content;
}

let formEdit = document.querySelector("#formEdit");
function showOne(id){
  axios.get(`${routeDetail}/${id}`)
  .then((response) => {
    if (response.data.status === 200) {
      let data = response.data.data;
      data.price = formatMoney(data.price);
      data.total = formatMoney(data.total);
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
    data.total = removeCommas(data.total);
    axios
      .put(`${routeDetail}/${id}`, data)
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
    let id = document.querySelector("#data-id").value;
    data.price = removeCommas(data.price);
    data.total = removeCommas(data.total);
    axios
      .put(route+`/${id}`, data)
      .then((response) => {
        console.log(response);
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



let changeProSer = document.querySelector("#changeProSer");
changeProSer.addEventListener('change',function(){
  let filter = this.value;
  axios
    .get('/api/products',{params:{filter,show: true}})
    .then((response) => {
      if (response.data.status === 200) {
        let data = response.data.data.data;
        let show = document.getElementById("showList");
        let content = '<option value="" hidden>Chọn SP & DV</option>';
        content += data.map((item) => {
          return `
            <option value="${item.id}">${item.name}</option>
          `;
        }).join('');
        show.innerHTML = content;
        show.disabled = false;
      }else if(response.data.status === 403){
        showMessageMD(response.data.errorMessage);
      }
    });
});
let showList = document.querySelector("#showList");
showList.addEventListener('change',function(){
  let id = this.value;
  axios
  .get(`/api/products/${id}`)
  .then((response) => {
    if (response.data.status === 200) {
      let data = response.data.data;
      document.getElementById("showPrice").value = formatMoney(data.price);
      document.getElementById("showUnit").value = data.unit_id;
      setTotal();
    }else if(response.data.status === 403){
      showMessageMD(response.data.errorMessage);
    }
  });
});

let showPrice = document.querySelector("#showPrice");
showPrice.addEventListener('input',function(){
  setTotal();
});
let showQuantity = document.querySelector("#showQuantity");
showQuantity.addEventListener('input',function(){
  setTotal();
});

function setTotal(){
  let showPrice = document.getElementById("showPrice");
  let showQuantity = document.getElementById("showQuantity");
  let price = removeCommas(showPrice.value);
  let total = price * showQuantity.value;
  document.getElementById("showTotal").value = formatMoney(total);
}
let showPriceE = document.querySelector("#showPriceE");
showPriceE.addEventListener('input',function(){
  setTotalE();
});
let showQuantityE = document.querySelector("#showQuantityE");
showQuantityE.addEventListener('input',function(){
  setTotalE();
});

function setTotalE(){
  let showPrice = document.getElementById("showPriceE");
  let showQuantity = document.getElementById("showQuantityE");
  let price = removeCommas(showPrice.value);
  let total = price * showQuantity.value;
  document.getElementById("showTotalE").value = formatMoney(total);
}