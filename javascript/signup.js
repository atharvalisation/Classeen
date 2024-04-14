const form = document.querySelector("form");
const signupButton = document.querySelector(".signUpButton");
let loading = document.getElementById("loading");

var selectYear = document.getElementsByName("year")[0];

function checkrole(s)
{
  if(s.value=="teacher")
  {
    selectYear.disabled = true;
  } else {
    selectYear.disabled = false;
  }
}

form.onsubmit = (e) => {
  e.preventDefault();
};

signupButton.addEventListener("click", () => {
  const xhr = new XMLHttpRequest();
  displayLoading();
  xhr.open("POST", "php/insert-data.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        hideLoading();
        if (data === "success") {
          location.href = "otp.php";
        } 
        else if (data === "Information Submitted, Verification will be completed in 2-3 office days!") {
          Swal.fire({
            title: "SIGNUP MESSAGE",
            text: data,
            icon: "success",
          });
        }
        else {
          Swal.fire({
            title: "SIGNUP MESSAGE",
            text: data,
            icon: "error",
          });
        }
      }
    }
  };

  let formData = new FormData(form);
  xhr.send(formData);
});

let displayLoading = () => {
  loading.classList.add("display");
  setTimeout(() => {
    loading.classList.remove("display");
  }, 15000);
};

let hideLoading = () => {
  loading.classList.remove("display");
};
