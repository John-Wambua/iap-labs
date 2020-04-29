const validateForm=()=>{
    const fname=document.forms['user_details']['first_name'].value;
    const lname=document.forms['user_details']['last_name'].value;
    const city=document.forms['user_details']['city_name'].value;
    const city=document.forms['user_details']['username'].value;
    const city=document.forms['user_details']['password'].value;

    if(fname===''||lname===''||city===''){
        alert('All details are required were not supplied');
        return false;
    }
    return true;
}