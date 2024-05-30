// khai báo cấu hình cơ bản cho choice js
const choiceOption = {
  searchEnabled: true,
  searchChoices: true,
  shouldSort: false,
  searchPlaceholderValue: "Tìm kiếm...",
  removeItemButton: true,
  searchResultLimit: 10,
  noResultsText: "Không có kết quả",
  noChoicesText: "Không có lựa chọn",
  placeholder: true,
  loadingText: "Đang tìm thông tin...",
  itemSelectText: "Chọn",
  fuseOptions: {
    keys: ["label"],
    threshold: 0.2,
    ignoreLocations: true,
    minMatchCharLength: 1,
    includeScore: true,
  },
};

const flatpickerOptions = {
  dateFormat: "d-m-Y",
  disableMobile: true,
  locale: "vn",
  shorthandCurrentMonth: true,
};

// Hàm Xử Lý format số tiền khi nhập
function debounce(func, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      func.apply(this, args);
    }, delay);
  };
}
// Format tiền
function formatMoney(amount) {
  let number = parseFloat(amount);

  if (isNaN(number)) {
    return "Invalid number";
  }

  return new Intl.NumberFormat("en-US", {
    maximumFractionDigits: 0,
  }).format(number);
}

const formatBalance = (event, number = 2) => {
  let balance = event.target.value.replace(/[^\d.-]/g, "");
  let index = balance.indexOf(".", balance.indexOf(".") + 1);
  if (index !== -1) {
    balance = balance.substring(0, index);
  }
  // const regex = /\.(?=.*\.)/g;
  // balance = balance.replace(regex, "");

  if (balance === "") {
    event.target.value = balance;
  } else {
    balance = parseFloat(balance);
    balance = balance.toLocaleString("en-US", {
      minimumFractionDigits: 0,
      maximumFractionDigits: number,
    });
    event.target.value = balance;
  }
};
const handleInputBalance = (event) => {
  delayedBalanceHandler(event, 2);
};

const handleInputNumber = (event) => {
  delayedNumberHandler(event, 3);
};

const delayedNumberHandler = debounce(formatBalance, 1000);

// Sử dụng debounce để tạo độ trễ cho sự kiện oninput
const delayedBalanceHandler = debounce(formatBalance, 1000);

// hàm thay đổi class ô input
// element phần tử cần hiện lỗi hoặc thành công, error có lỗi hay không , message là lỗi muốn hiện ra, listClass là danh sách class tuỳ chỉnh muốn thêm vào phần tử đó
const changeMessageError = (
  element,
  error = false,
  message = "",
  listClass = ["p-2", "small"],
  isNotChoiceJs = true
) => {
  if (!isNotChoiceJs) {
    element = element.parentNode.parentNode;
  }

  let parentNode = element.parentNode;

  let classError = "show-error";
  let listElementError = parentNode.getElementsByClassName(classError);

  if (error) {
    if (listElementError[0]) {
      listElementError.innerHTML = message;
    } else {
      let newElement = document.createElement("div");
      newElement.classList.add(classError, "text-danger");

      for (const i of listClass) {
        newElement.classList.add(i);
      }

      newElement.innerHTML = message;
      parentNode.appendChild(newElement);
    }
  } else {
    if (listElementError[0]) {
      parentNode.removeChild(listElementError[0]);
    }
  }
  changeClassError(element, error, !isNotChoiceJs);
};
const changeClassError = (element, error = false, isChoiceJs = false) => {
  if (error) {
    // thêm class báo lỗi
    if (isChoiceJs) {
      element.classList.add("custom-validate");
      element.classList.remove("valid");
      element.classList.add("invalid");
    } else {
      element.classList.remove("form-success");
      element.classList.add("form-error");
    }
  } else {
    // xoá class báo lỗi
    if (isChoiceJs) {
      element.classList.add("custom-validate");
      element.classList.remove("invalid");
      element.classList.add("valid");
    } else {
      element.classList.remove("form-error");
      element.classList.add("form-success");
    }
  }
};

function clearAllClassValidate(element) {
  // Lấy ra tất cả các phần tử trong biểu mẫu có class là "form-errors" hoặc "invalid" ...
  let elementsWithErrors = element.querySelectorAll(
    ".form-error, .invalid, .valid, .form-success"
  );
  // Lặp qua từng phần tử và loại bỏ lớp "form-errors" và "invalid" ...
  elementsWithErrors.forEach(function (ele) {
    ele.classList.remove("form-error");
    ele.classList.remove("invalid");
    ele.classList.remove("valid");
    ele.classList.remove("form-success");
  });
  let elementShowError = element.querySelectorAll(".show-error");
  elementShowError.forEach((ele) => {
    ele.remove();
  });
}

const formatNumber = (numberString, max = 0) => {
  return parseFloat(numberString).toLocaleString("en-US", {
    minimumFractionDigits: 0,
    maximumFractionDigits: max,
  });
};

const dateFormat = (date) => {
  let currentDate = new Date(date);

  let day = currentDate.getDate().toString().padStart(2, "0"); // Add leading zero if needed
  let month = (currentDate.getMonth() + 1).toString().padStart(2, "0"); // Month is zero-based
  let year = currentDate.getFullYear();

  return `${day}-${month}-${year}`;
};

const changeSizeText = (text, maxLength = 100) => {
  if (text.length > maxLength) {
    text = text.substring(0, maxLength) + "...";
  }
  return text;
};
const showMessage = (element, message) => {
  element.innerHTML = message;
  element.style.display = "block";
  setTimeout(() => {
    element.innerHTML = "";
    element.style.display = "none";
  }, 4500);
};

const buildPagination2 = (data, element, functionName) => {
  let html = `<div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
    <div class="col-auto d-flex">
        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
          ${data.from} đến ${data.to} <span class="text-body-tertiary"> trong </span> ${data.total} 
          <button class="btn text-primary" onclick="${functionName}('${data.url}?show=${data.show === 'true' ? 'false' : 'true'}')" >${data.show === 'true' ? 'Ẩn bớt' : 'Xem tất cả'} &#8645;</button>
        </p> 
    </div>
    <nav class="col-auto d-flex">
      <ul class="mb-0 pagination justify-content-end">
        <li class="page-item ${data.current_page <= 1 ? "disabled" : ""}">
          <a class="page-link ${data.current_page <= 1 ? "disabled" : ""}" ${data.current_page <= 1 ? 'disabled=""' : ""} href="javascript:" title="Trang trước" onclick="${functionName}('${data.url + data.params + (data.current_page - 1)}')">
              <span class="fas fa-chevron-left"></span>
          </a>
        </li>
  `;
  if (data.current_page - 3 > 1) {
    html += `<li class="page-item disabled"><a class="page-link" disabled="" title="" type="button" href="javascript:">...</a>`;
  }
  for (let i = data.current_page - 3; i <= data.current_page + 3; i++) {
    if (i > 0 && i <= data.total_pages) {
      if (i === data.current_page) {
        html += `
          <li class="page-item active">
            <a class="page-link" title="Trang ${i}" href="javascript:" type="button">${i}</a>
          </li>`;
      } else {
        html += `
          <li class="page-item">
            <a class="page-link" type="button" title="Trang ${i}" href="javascript:" onclick="${functionName}('${data.url + data.params + i}')">${i}</a>
          </li>`;
      }
    }
  }
  if (data.current_page + 3 < data.total_pages) {
    html += `
      <li class="page-item disabled">
        <a class="page-link" disabled="" title="" type="button" href="javascript:">...</a>
      </li>
    `;
  }
  html += `
          <li class="page-item ${data.current_page === data.total_pages ? "disabled" : ""}">
            <a class= "page-link ${data.current_page === data.total_pages ? "disabled" : ""}"${data.current_page === data.total_pages ? 'disabled=""' : ""} href="javascript:" title="Trang sau" 
                onclick="${functionName}('${data.url + data.params + (data.current_page + 1)}')" >
            <span class= "fas fa-chevron-right"></span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    `;
  element.innerHTML = html;
};

const buildPagination = (data, element, functionName) => {
  let html = `<div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                ${data.from} đến ${
    data.to} <span class="text-body-tertiary"> trong </span> ${data.total}
                </p> 
            </div>
                <nav class="col-auto d-flex">
                    <ul class="mb-0 pagination justify-content-end">
                        <li class="page-item ${
                          data.current_page <= 1 ? "disabled" : ""
                        }"><a class="page-link ${
    data.current_page <= 1 ? "disabled" : ""
  }" ${
    data.current_page <= 1 ? 'disabled=""' : ""
  } href="javascript:" title="Trang trước" onclick="${functionName}('${
    data.url + data.params + (data.current_page - 1)
  }')">
                            <span class="fas fa-chevron-left"></span></a></li>`;
  if (data.current_page - 3 > 1) {
    html += `<li class="page-item disabled"><a class="page-link" disabled="" title="" type="button" href="javascript:">...</a>`;
  }
  for (let i = data.current_page - 3; i <= data.current_page + 3; i++) {
    if (i > 0 && i <= data.total_pages) {
      if (i === data.current_page) {
        html += `<li class="page-item active"><a class="page-link" title="Trang ${i}" href="javascript:" type="button">${i}</a></li>`;
      } else {
        html += `<li class="page-item"><a class="page-link" type="button" title="Trang ${i}" href="javascript:" onclick="${functionName}('${
          data.url + data.params + i
        }')">${i}</a></li>`;
      }
    }
  }
  if (data.current_page + 3 < data.total_pages) {
    html += `<li class="page-item disabled"><a class="page-link" disabled="" title="" type="button" href="javascript:">...</a></li>`;
  }
  html += `
        <li class="page-item ${
          data.current_page === data.total_pages ? "disabled" : ""
        }">
            <a class= "page-link ${
              data.current_page === data.total_pages ? "disabled" : ""
            }" ${data.current_page === data.total_pages ? 'disabled=""' : ""}
            href="javascript:" title="Trang sau"  onclick="${functionName}('${
    data.url + data.params + (data.current_page + 1)
  }')" ><span class= "fas fa-chevron-right"></span></a></li>
    </ul></nav></div>
    `;
  element.innerHTML = html;
};

const showMessageMD = (content, time = 4500) => {
  let modal = document.getElementById("modalSuccessNotification");
  let myModal = new bootstrap.Modal(modal, {
    keyboard: false,
    backdrop: false,
  });
  let element = modal.getElementsByClassName("success-message")[0];
  element.innerHTML = content;
  myModal.show();
  setTimeout(() => {
    element.innerHTML = "";
    myModal.hide();
  }, time);
};

const showErrorMD = (content, time = 4500) => {
  let modal = document.getElementById("modalErrorNotification");
  let myModal = new bootstrap.Modal(modal, {
    keyboard: false,
    backdrop: false,
  });
  let element = modal.getElementsByClassName("error-message")[0];
  element.innerHTML = content;
  myModal.show();
  setTimeout(() => {
    element.innerHTML = "";
    myModal.hide();
  }, time);
};

const confirmDelete = (url, title, getData) => {
  let modal = document.getElementById("modalConfirmDelete");
  let btnConfirmDelete = modal.getElementsByClassName("btn-confirm")[0];
  let myModal = new bootstrap.Modal(modal, {
    keyboard: false,
  });
  let element = modal.getElementsByClassName("confirm-message")[0];
  element.innerHTML = `Chắc chắn xoá ${title} này!`;
  myModal.show();
  btnConfirmDelete.addEventListener("click", () => {
    btnLoading(btnConfirmDelete, true);
    axios
      .delete(url)
      .then((res) => {
        if (res.data.status == 200) {
          myModal.hide();
          getData();
          showMessageMD(res.data.successMessage);
        } else if (res.data.errorMessage) {
          showErrorMD(res.data.errorMessage);
        }
        myModal.hide();
        btnLoading(btnConfirmDelete, false);
      })
      .catch((error) => {
        console.log(error);
        btnLoading(btnConfirmDelete, false);
      });
  });
};
//  hàm validation cho ô inputs
const validateNotEmpty = (element) => {
  if (element.value.trim() === "") {
    changeMessageError(
      element,
      true,
      `Vui lòng nhập ${element.placeholder.toLowerCase()}!`,
      ["p-2", "small"]
    );
    return false;
  } else {
    changeMessageError(element, false);
    return true;
  }
};

// hàm validation cho selection
const validateSelectOption = (element, text, isChoiceJs = false) => {
  if (element.value.trim() == "") {
    changeMessageError(
      element,
      true,
      `Vui lòng chọn ${text}!`,
      ["p-2", "small"],
      !isChoiceJs
    );
    return false;
  } else {
    changeMessageError(element, false, "", [], !isChoiceJs);
    return true;
  }
};

// hàm hiện loading và vo hiệu hoá nút
const btnLoading = (btn, isload = true, text = "") => {
  if (isload) {
    btn.disabled = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm" style="--phoenix-spinner-width: 0.8rem;--phoenix-spinner-height: 0.8rem" role="status" aria-hidden="true"></span> ${btn.title}`;
  } else {
    btn.disabled = false;
    if (text) {
      btn.innerHTML = `${text}`;
    } else {
      btn.innerHTML = `${btn.title}`;
    }
  }
};

function time_ago(time) {
  if (
    typeof time === "string" &&
    (time == "0000-00-00 00:00:00" || time == "0000-00-00")
  ) {
    return "Chưa đăng nhập";
  }

  switch (typeof time) {
    case "number":
      break;
    case "string":
      time = +new Date(time);
      break;
    case "object":
      if (time.constructor === Date) time = time.getTime();
      break;
    default:
      time = +new Date();
  }
  var time_formats = [
    [60, "giây", 1], // 60
    [120, "1 phút trước", "1 phút sau"], // 60*2
    [3600, "Phút", 60], // 60*60, 60
    [7200, "1 giờ trước", "1 giờ sau"], // 60*60*2
    [86400, "giờ", 3600], // 60*60*24, 60*60
    [172800, "hôm qua", "Ngày mai"], // 60*60*24*2
    [604800, "ngày", 86400], // 60*60*24*7, 60*60*24
    [1209600, "tuần trước", "Tuần sau"], // 60*60*24*7*4*2
    [2419200, "tuần", 604800], // 60*60*24*7*4, 60*60*24*7
    [4838400, "tháng trước", "Tháng sau"], // 60*60*24*7*4*2
    [29030400, "tháng", 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
    [58060800, "năm trước", "năm sau"], // 60*60*24*7*4*12*2
    [2903040000, "năm", 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
    // [5806080000, 'thế kỷ trước', 'thế kỷ tiếp theo'], // 60*60*24*7*4*12*100*2
    // [58060800000, 'thế kỷ', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
  ];
  var seconds = (+new Date() - time) / 1000,
    token = "trước",
    list_choice = 1;

  if (seconds == 0) {
    return "Vừa xong";
  }
  if (seconds < 0) {
    seconds = Math.abs(seconds);
    token = "sau";
    list_choice = 2;
  }
  var i = 0,
    format;
  while ((format = time_formats[i++]))
    if (seconds < format[0]) {
      if (typeof format[2] == "string") return format[list_choice];
      else
        return Math.floor(seconds / format[2]) + " " + format[1] + " " + token;
    }
  format = time_formats[time_formats.length - 1];
  return Math.floor(seconds / format[2]) + " " + format[1] + " " + token;
}

const dateTimeFormat = (date, format = "d-m-Y") => {
  let currentDate = new Date(date);

  let seconds = currentDate.getSeconds().toString().padStart(2, "0"); // Add leading zero if needed
  let minutes = currentDate.getMinutes().toString().padStart(2, "0"); // Add leading zero if needed
  let hours = currentDate.getHours().toString().padStart(2, "0"); // Add leading zero if needed
  let day = currentDate.getDate().toString().padStart(2, "0"); // Add leading zero if needed
  let month = (currentDate.getMonth() + 1).toString().padStart(2, "0"); // Month is zero-based
  let year = currentDate.getFullYear();
  let result = format.replace("i", minutes);
  result = result.replace("s", seconds);
  result = result.replace("H", hours);
  result = result.replace("d", day);
  result = result.replace("m", month);
  result = result.replace("Y", year);
  return result;
};

const displayTime = (time, format = "H:i") => {
  const timeParts = time.split(":");
  if (timeParts.length !== 3) {
    return "Invalid time format";
  }
  const hours = timeParts[0];
  const minutes = timeParts[1];
  const seconds = timeParts[2];

  let result = format.replace("i", minutes);
  result = result.replace("s", seconds);
  result = result.replace("H", hours);
  return result;
};

const getStatusName = (status) => {
  switch (status) {
    case 1:
      return '<span class="badge badge-phoenix badge-phoenix-warning pb-1 pt-1">Đang theo</span>';
    case 2:
      return '<span class="badge badge-phoenix badge-phoenix-success pb-1 pt-1">Thành công</span>';
    case 3:
      return '<span class="badge badge-phoenix badge-phoenix-danger pb-1 pt-1">Thất bại</span>';
  }
  return "";
};
