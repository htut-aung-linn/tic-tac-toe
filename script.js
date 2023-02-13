const xhttp = new XMLHttpRequest();
        function start(){
            btndis(false);
            document.getElementById("start-btn").disabled = true;
            document.getElementById("end-btn").disabled = false;
            document.getElementById("broad").style.display ="flex";
            document.getElementById("setting").style.display ="none";
            let formElements = document.getElementById("frm1").elements;
            let level = document.getElementsByName("level");
            let levelValue;
            for (let i = 0; i < level.length; i++) {
                let lev = level[i];
                if (lev.checked) {
                    levelValue = lev.value;
                    break;
                }
            }
            
            let turn = document.getElementsByName("turn");
            let turnValue;
            for (let i = 0; i < turn.length; i++) {
                let tu = turn[i];
                if (tu.checked) {
                    turnValue = tu.value;
                    break;
                }
            }

            var com = "off";
            if(document.getElementsByName("computer")[0].checked){
                com = "on";
            }
            const formValues= levelValue+ ","+turnValue+ ","+ com;
            xhttp.onload = function() {
                var js_array = JSON.parse(this.responseText);
                setMap(js_array);
                }
            xhttp.open("GET", "gameView.php?setting=" + formValues, true);
            xhttp.send();
        }
       
        function end(){
            document.getElementById("start-btn").disabled = false;
            document.getElementById("end-btn").disabled = true;
            document.getElementById("broad").style.display ="none";
            document.getElementById("setting").style.display ="block";
            document.getElementById("end-btn").style.fontSize = "1rem";
            document.getElementById("end-btn").style.borderColor = "darkmagenta";
            document.getElementById("noti").style.display ="none";
        }
        
        function change(strin){
            xhttp.onload = function() {
                console.log(xhttp.responseText);
                var js_array = JSON.parse(xhttp.responseText);
                setMap(js_array);
                if(js_array[3][0]){
                    document.getElementById("noti").style.display ="flex";
                    document.getElementById("noti").style.color = "gold";
                    document.getElementById("noti").innerHTML = "<p>You win!</p>"
                    document.getElementById("end-btn").style.fontSize = "2em";
                    document.getElementById("end-btn").style.borderColor = "gold";
                    btndis(true);
                }
                if(js_array[3][1]){
                    document.getElementById("noti").style.display ="flex";
                    document.getElementById("noti").style.color = "red";
                    document.getElementById("noti").innerHTML = "<p>You Lose!, Try again.<p>"
                    document.getElementById("end-btn").style.fontSize = "2rem";
                    document.getElementById("end-btn").style.borderColor = "red";
                    btndis(true);
                }
                if(js_array[3][2]){
                    document.getElementById("noti").style.display ="flex";
                    document.getElementById("noti").style.color = "orange";
                    document.getElementById("noti").innerHTML = "<p>Draw!</p>"
                    document.getElementById("end-btn").style.fontSize = "2rem";
                    document.getElementById("end-btn").style.borderColor = "orange";
                    btndis(true);
                }
            }
            xhttp.open("GET", "gameView.php?pos=" + strin ,true);
            xhttp.send();
        }

        function setMap(array){
            document.getElementById("00").innerHTML = array[0][0];
            document.getElementById("01").innerHTML = array[0][1];
            document.getElementById("02").innerHTML = array[0][2];
            document.getElementById("10").innerHTML = array[1][0];
            document.getElementById("11").innerHTML = array[1][1];
            document.getElementById("12").innerHTML = array[1][2];
            document.getElementById("20").innerHTML = array[2][0];
            document.getElementById("21").innerHTML = array[2][1];
            document.getElementById("22").innerHTML = array[2][2];
        }
        document.getElementById("broad").style.display ="none";
        document.getElementById("noti").style.display ="none";

        function btndis(bool){
            document.getElementById("00").disabled = bool;
            document.getElementById("01").disabled = bool;
            document.getElementById("02").disabled = bool;
            document.getElementById("10").disabled = bool;
            document.getElementById("11").disabled = bool;
            document.getElementById("12").disabled = bool;
            document.getElementById("20").disabled = bool;
            document.getElementById("21").disabled = bool;
            document.getElementById("22").disabled = bool;
        }

        
        