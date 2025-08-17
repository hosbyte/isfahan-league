
// * jquery test
$(document).ready(function () {
  console.log("jQuery loaded"); 
});

// * register 
function rsend()
{
    const team_id = $('#dropdown').val();
    const gf = $('#gf').val();
    const ga = $('#ga').val();

    if (!team_id || !gf || !ga) {
        alert("لطفاً تمام فیلدها را پر کنید.");
        return;
    }
    $.ajax({
        url : 'register.php',
        method : 'POST',
        data :{
        team_id : $('#dropdown').val(),
        gf : $('#gf').val(),
        ga : $('#ga').val()
        },
        success : function(reg)
        {
            reg.trim() === '1'
            ?window.location.href='register.php'
            : alert ("ثبت انجام نشد");
        },
        error : function()
        {
            alert ("اتصال انجام نشد");
        }
    });
}

// TODO:
// * show table
$(document).ready(function () {
    $('#leaguetable').on('submit' , function(e) {
        e.preventDefault();
        const table = $('#table').val();

        if(!table){
            alert("لطفاً تمام فیلدها را پر کنید.");
            return;
        }

        $.ajax({
            url : 'register.php',
            method : 'POST',
            data :{
                table : $('#table').val(),
            },
            success : function(show_t){
                show_t = show_t.trim();
                if(show_t ==='1'){ 
                    window.location.href = 'register.php';
                    console.log("yes");
                    console.log(table);
                  }
                  else{
                      console.log("no");
                      console.log(table);
                      alert ("جدول انتخاب نشد");
                  }
            },
            error : function(){
                alert ("اتصال انجام نشد");
            },
        });
    });
});