        let logoutBtn = document.getElementsByClassName('logout')[0];
        let logoutInput = document.getElementsByName('logout')[0];
        
        logoutBtn.addEventListener('click', ()=>{
                logoutInput.click();
        });
        
        logoutBtn.addEventListener('click', ()=>{
                logoutInput.click();
        });

        date_picker();

        function date_picker(){
                
                let div = document.getElementsByClassName('date_picker')[0];
                let today = new Date();
                let dayInput = document.createElement('select');
                dayInput.setAttribute('name', 'day');
                let monthInput = document.createElement('select');
                monthInput.setAttribute('name', 'month');
                let yearInput = document.createElement('select');
                yearInput.setAttribute('name', 'year');
                
                let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                for (let m = 0; m <= 11; m++) {
                        let option = document.createElement('option');
                        option.setAttribute('value', m.toLocaleString('en-US', {minimumIntegerDigits: 2}));
                        if(m == today.getMonth()){
                                option.setAttribute('selected', '');
                        }
                        option.innerHTML = months[m];
                        monthInput.appendChild(option);
                }
                div.appendChild(monthInput);
        
                generateDays(today.getMonth(), today.getFullYear(), false);
        
                for (let y = today.getFullYear()-90; y <= today.getFullYear()-18; y++) {
                        let option = document.createElement('option');
                        option.setAttribute('value', y);
                        if(y == today.getFullYear()-18){
                                option.setAttribute('selected', '');
                        }
                        option.innerHTML = y;
                        yearInput.appendChild(option);
                }
                div.appendChild(yearInput);
                
                monthInput.addEventListener('input', ()=>{
                        generateDays(monthInput.value, yearInput.value, true, dayInput.value,);
                })
                yearInput.addEventListener('input', ()=>{
                        generateDays(monthInput.value, yearInput.value, true, dayInput.value);
                })
                
                function generateDays(month, year, def, day = null){
                        let nDays;
                        dayInput.innerHTML = '';
                        if (month != 1) {
                                if(month == 0 || month == 2 || month== 4 || month == 6 || month == 7 || month == 9 || month == 11){
                                        nDays = 31;
                                }else{
                                        nDays = 30;
                                }
                        }else{
                                if(year%4 == 0 && year%100 != 0 ){
                                        nDays= 29;
                                }else if(year%100 == 0 && year%400 == 0){
                                        nDays= 29;
                                }else {
                                        nDays = 28;
                                }
                        }
        
                        for (let d = 1; d <= nDays; d++) {
                                let option = document.createElement('option');
                                option.setAttribute('value', d.toLocaleString('en-US', {minimumIntegerDigits: 2}));
                                if((d == today.getDate() && def == false) || d == day){
                                        option.setAttribute('selected', 'true');
                                }
                                option.innerHTML = d.toLocaleString('en-US', {minimumIntegerDigits: 2});
                                dayInput.appendChild(option);
                        }
                        div.insertBefore(dayInput, monthInput);
                }
        }