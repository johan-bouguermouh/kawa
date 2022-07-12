window.addEventListener("DOMContentLoaded", () => {
  let btn = document.querySelector(".btn");
  let panel = document.querySelector(".container");
  let close = document.querySelector(".close");
  const inputSearch = document.querySelector('input[type=search]');

  btn.addEventListener("click", () => {
    panel.classList.add("active");
  });

  close.addEventListener("click", () => {
    panel.classList.remove("active");
  });

  inputSearch.addEventListener("input", (event)=>{
    event.preventDefault()
    if(inputSearch.value.length > 2){

      const dataSearch = new FormData
      dataSearch.set('recherhe', inputSearch.value)

      fetch('',{
        method: 'POST',
        body: dataSearch
      })
    }
  })
});
