function validateForm() {
    const password = document.getElementById("password").value;
    // const username = document.getElementById("username").value;
    
    const passwordErrors = validatePassword(password);
   // const usernameErrors = validateUsername(username);
    
     const allErrors = [...passwordErrors];
    
    if (allErrors.length > 0) {
      alert(allErrors.join("\n"));
      return false;
    }
    return true;
  }
  
//   function validateUsername(username) {
//     const errors = [];
//     if (username.length < 8) {
//       errors.push("Username must be at least 8 characters long");
//     }
//     // Add more username validations here
//     return errors;
//   }
  function validatePassword(password) {
    const errors = [];
    if (password.length < 7) {
      errors.push("Password must be at least 7 characters long");
    }
    if (!/[A-Z]/.test(password)) {
      errors.push("Password must contain at least one uppercase letter");
    }
    if (!/[a-z]/.test(password)) {
      errors.push("Password must contain at least one lowercase letter");
    }
    if (!/\d/.test(password)) {
      errors.push("Password must contain at least one number");
    }
    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
      errors.push("Password must contain at least one special character");
    }
    return errors;
  }
  
  