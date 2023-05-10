function validatePassword(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return regex.test(password);
}

const newPasswordInput = document.getElementById("newPassword");
const confirmPasswordInput = document.getElementById("confirmPassword");

const caracteristiqueNewMdp = document.getElementById("caracteristiqueNewMdp");
const caracteristiqueConfMdp = document.getElementById("caracteristiqueConfMdp");



newPasswordInput.onkeyup
newPasswordInput.addEventListener("keyup", () => {
    const newPassword = newPasswordInput.value;
    const isValid = validatePassword(newPassword);
    if (isValid) {
        newPasswordInput.classList.remove("invalid");
        newPasswordInput.classList.add("valid");
        caracteristiqueNewMdp.classList.remove("invalid");
        caracteristiqueNewMdp.classList.add("valid");
    } else {
        newPasswordInput.classList.remove("valid");
        newPasswordInput.classList.add("invalid");
        caracteristiqueNewMdp.classList.remove("valid");
        caracteristiqueNewMdp.classList.add("invalid");

    }
});

confirmPasswordInput.addEventListener("keyup", () => {
    const newPassword = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    if (newPassword !== confirmPassword) {
        confirmPasswordInput.classList.remove("valid");
        confirmPasswordInput.classList.add("invalid");
        caracteristiqueConfMdp.classList.remove("valid");
        caracteristiqueConfMdp.classList.add("invalid");
        caracteristiqueConfMdp.textContent = "Les mot de passes ne correspondent pas";
    } else {
        confirmPasswordInput.classList.remove("invalid");
        confirmPasswordInput.classList.add("valid");
        caracteristiqueConfMdp.classList.remove("invalid");
        caracteristiqueConfMdp.classList.add("valid");
        caracteristiqueConfMdp.textContent = "Les mot de passes correspondent";
    }
});
