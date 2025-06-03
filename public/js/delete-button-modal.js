const buttons = document.querySelectorAll(".delete-button");
const modal = document.querySelector(".delete-modal");

const confirmButton = document.querySelector('.modal-confirm-button');
const cancelButton = document.querySelector(".modal_cancel_button");
cancelButton.addEventListener("click", function(){
    modal.classList.add('hidden');
})

confirmButton.addEventListener("click", function () {
    sendDeleteRequest();
})

const dataForm = document.querySelector(".data-form");
const dataInput = document.querySelector(".data-input");

function sendDeleteRequest(){
    dataForm.submit();
}

buttons.forEach(button => {
    button.addEventListener("click", (e)=>{
        const affectedId = button.dataset.id;
        const row = document.querySelectorAll(".row" + affectedId);

        for (var i = 1; i < row.length; i++){
            var modalDesc = document.querySelector('.modal-row' + (i-1));

            modalDesc.innerText = row[i].innerText;
        }
        
        confirmButton.dataset.id = affectedId;
        dataInput.value = affectedId;
        
        modal.classList.remove('hidden');
    })
});