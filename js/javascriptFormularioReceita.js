const formContainer = document.getElementById("form-container");
const overlay = document.getElementById("overlay");
const closeBtn = document.getElementById("close-btn");
const cancelBtn = document.getElementById("cancel-btn");

// Exibir o formulário
function abrirFormulario() {
  formContainer.style.display = "block";
  overlay.style.display = "block";
}

// Fechar o formulário
function fecharFormulario() {
  formContainer.style.display = "none";
  overlay.style.display = "none";
}

// Eventos para fechar
closeBtn.addEventListener("click", fecharFormulario);
cancelBtn.addEventListener("click", fecharFormulario);

// Testar abertura (simule com setTimeout ou botão de teste)
setTimeout(abrirFormulario, 1000);
