const form = document.querySelector("form");
const postButton = document.querySelector(".post__button");
const modalForm = document.querySelector(".modal__form");
const overlayForm = document.querySelector(".overlay");
const cardContainer = document.querySelector(".card__container");
const deleteIcon = document.querySelector("#deleteIcon");

const title = document.querySelector("#title");
const message = document.querySelector("#message");
const myFile = document.querySelector("#myFile");

const inputField = document.querySelector("#title");
const currentCharacters = document.getElementById("currentCharacters");

form.onsubmit = (e) => {
  e.preventDefault();
  refreshPage();
};

const refreshPage = () => {
  const xhr = new XMLHttpRequest();
  let currentUrl = window.location.href;
  let url = new URL(currentUrl);
  let page = url.searchParams.get("page");
  if (page === "mails") {
    xhr.open("POST", "php/get-mail-notice.php", true);
  } else {
    xhr.open("POST", "php/get-notices.php", true);
  }
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        cardContainer.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (page === "time_table") {
    let forPage = url.searchParams.get("forPage");
    xhr.send("page=" + page + "&forPage=" + forPage);
  } else {
    xhr.send("page=" + page);
  }
};

inputField.onkeyup = () => {
  inputField.value.length == 50
    ? (currentCharacters.style.color = "crimson")
    : (currentCharacters.style.color = "black");
  currentCharacters.innerText = inputField.value.length;
};

var interval = setInterval(refreshPage, 60000);

refreshPage();

postButton.addEventListener("click", () => {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "php/pop-up-insert.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        Swal.fire({
          title: "NOTICE MESSAGE",
          text: data,
          icon: data === "Notice added successfully" ? "success" : "error",
        }).then(() => {
          title.value = message.value = myFile.value = "";
          modalForm.classList.add("hidden");
          overlayForm.classList.add("hidden");
          currentCharacters.innerText = 0;
          refreshPage();
        });
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
});

// SEARCH BAR

const searchBar = document.querySelector(".header__input");
searchBar.onkeyup = () => {
  let searchValue = searchBar.value.trim();
  if (searchValue) {
    let currentUrl = window.location.href;
    let url = new URL(currentUrl);
    let page = url.searchParams.get("page");
    const xhr = new XMLHttpRequest();
    if (page === "mails") {
      xhr.open("POST", "php/search-mails.php", true);
    } else {
      xhr.open("POST", "php/search.php", true);
    }
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          cardContainer.innerHTML = data;
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (page === "mails") {
      xhr.send("search=" + searchValue);
    } else if (page === "time_table") {
      let forPage = url.searchParams.get("forPage");
      xhr.send(
        "search=" + searchValue + "&page=" + page + "&forPage=" + forPage
      );
    } else {
      xhr.send("search=" + searchValue + "&page=" + page);
    }
  }
};

const setPageRefreshInterval = () => {
  interval = setInterval(refreshPage, 60000);
};

const clearPageRefreshInterval = () => {
  clearInterval(interval);
};

const setPageRefreshIntervalIfSearchBarIsEmpty = (e) => {
  console.log(e.target.value.toString());
  if (!e.target.value) {
    setPageRefreshInterval();
  }
};

const handleNoticeDelete = (event, id) => {
  event.preventDefault();
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "php/delete-notice.php", true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const data = xhr.response;
            Swal.fire({
              title: "NOTICE MESSAGE",
              text: data,
              icon: data === "Notice has been deleted" ? "success" : "error",
            });
            refreshPage();
          }
        }
      };
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("id=" + id);
    }
  });
};
