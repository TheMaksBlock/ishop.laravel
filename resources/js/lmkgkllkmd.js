function getCourse(){
    let xhr = new XMLHttpRequest();
    let URL = 'https://api.nbrb.by/exrates/currencies/5';
    xhr.open('GET', URL);
    xhr.send();
    xhr.onload=function(){
        if(xhr.status != 200){
            alert(`Error ${xhr.status}:${xhr.statusText}`);
        } else{
            let response = JSON.parse(xhr.response);
            SetCurrency(response);
            getCurrencyRate(response.Cur_ID (e=>{
                let response = JSON.parse(e.target.response);
                SetCourensyRate(response);
            }));
        }
    }
    xhr.onerror=function(){
        alert(`Error`);
    }

}

function getCurrencyRate(id, onload){
    let xhr = new XMLHttpRequest();
    let URL = `https://api.nbrb.by/exrates/rates/${id}`;
    xhr.open('GET', URL);
    xhr.onload=onload;
    xhr.send();
    xhr.onload = onload;

    return xhr;
}