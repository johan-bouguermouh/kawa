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
      dataSearch.set('recherche', inputSearch.value)

      fetch('../Api/apiSearch.php',{
        method: 'POST',
        body: dataSearch
      }).then(response => response.text())
      .then(data => console.log('RETOUR DE JSON ==>',data))
    }
  })
});
