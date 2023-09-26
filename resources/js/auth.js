export function checkLoginStatus() {
    return window.Laravel.isLoggedin;
  }


//Admin auth

export function checkLoginAdmin() {
    return (window.Laravel.isLoggedin && window.Laravel.user.role==2)
    }
//Client auth
export function checkLoginClient() {
    return (window.Laravel.isLoggedin && (window.Laravel.user.role==1|| window.Laravel.user.role==null))
}


//Client disabled
export function checkClientDisabled() {
    if (checkLoginClient()){
        return (window.Laravel.user.disabled==true)
    }
    return false
}

//Check Client email verified
export function checkClientVerification() {
    if (checkLoginClient()){
        return (window.Laravel.user.email_verified_at!=null)
        }
        return false

    }
//Check Client email not verified
export function checkClientNotVerified() {
    if (checkLoginClient()){
        return (window.Laravel.user.email_verified_at==null)
        }
        return false

    }
