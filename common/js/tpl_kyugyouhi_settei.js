var BASE_AJAX_URL = '/outlet/valeur/seller/calendar_reg.php';
$(document).ready(function () {
    
    const highlightedDates = [];
    make_html(highlightedDates);
   function make_html(highlightedDates = []){
        const currentMonthTable = $('.currentMonthTable');
        const nextMonthTable = $('.nextMonthTable');
        const currentMonthHeader = $('.currentMonthHeader');
        const nextMonthHeader = $('.nextMonthHeader');
       

        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();
        
        currentMonthTable.each(function (index, element) {
            $(element).html(generateMonthTable(currentMonth, currentYear, highlightedDates));
        });

        
        currentMonthHeader.text(getMonthNameJapanese(currentMonth) + ' ' + currentYear);

        // let temDate = setMonth(currentDate.getMonth() + 1);
        const nextMonthDate = new Date(currentDate);
        nextMonthDate.setMonth(nextMonthDate.getMonth() + 1);

        const nextMonth = nextMonthDate.getMonth();
        currentDate.setMonth(currentDate.getMonth() + 1);
        
        
        // const nextMonth = currentDate.getMonth();
        const nextYear = currentDate.getFullYear();

        // nextMonthTable.html(generateMonthTable(nextMonth, nextYear, highlightedDates));
        nextMonthTable.each(function (index, element) {
            $(element).html(generateMonthTable(nextMonth, nextYear, highlightedDates));
        });
        nextMonthHeader.text(getMonthNameJapanese(nextMonth) + ' ' + nextYear)
   }

    function generateMonthTable(month, year, highlightedDates) {
        if(month == 0){
            month = month;
        }else{
            month = month - 1;
        }
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let tableHtml = '';
        
        for (let i = 1; i <= daysInMonth; i++) {
            const dayOfWeek = new Date(year, month, i).getDay();
            if (i === 1) {
                tableHtml += '<tr>';
                for (let j = 0; j < dayOfWeek; j++) {
                    tableHtml += '<td></td>';
                }
            }

            const currentDateFormatted = `${year}/${String(month + 1).padStart(2, '0')}/${String(i).padStart(2, '0')}`;
            const isHighlighted = highlightedDates.includes(currentDateFormatted);

            tableHtml += `<td class="select_date" data-date="${currentDateFormatted}" ${isHighlighted ? 'class="bg-info text-white cursor-pointer-important"' : 'class="cursor-pointer cursor-pointer-important"'}>${i}</td>`;

            if (dayOfWeek === 6 && i !== daysInMonth) {
                tableHtml += '</tr><tr>';
            }
        }

        return tableHtml;
    }

    function getMonthNameJapanese(month) {
        if(month == 0){
            month = month;
        }else{
            month = month- 1;
        }
        const months = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
        return months[month];
    }


    $(document.body).on('click', '.select_date', function(){
            var date = $(this).attr('data-date');
            var index = highlightedDates.indexOf(date);
            if (index === -1) {
                highlightedDates.push(date);
                $(this).addClass('bg-info text-white');
            } else {
                highlightedDates.splice(index, 1);
                $(this).removeClass('bg-info text-white');
            }
    });



    $('#set_kyugyouModal').click(() => {
        // Save the array of date strings to localStorage
        localStorage.setItem('kyugyouhi', JSON.stringify(highlightedDates));
        // Log the array to the console for verification
        var datesList = document.getElementById("datesList");

        // Clear any existing content in the ul
        datesList.innerHTML = '';
        
        // Loop through each date in the highlightedDates array
        highlightedDates.forEach(function(dateString) {
          // Create a list item element
          var listItem = document.createElement("li");
          listItem.textContent = dateString;
        
          // Append the list item to the ul
          // ナム　2024/01/26
        //   datesList.appendChild(listItem);
        });
        $('#kyugyouModal').modal('hide');
    });  

    // 休業日設定表名をチェック
    $(document.body).on('blur', '#holiday_name', function(){
        var holiday_name = $('#holiday_name').val();
        if(holiday_name != ''){
            var request = $.ajax({
                type : 'POST',
                URL : BASE_AJAX_URL,
                data : {holiday_name, p_kind : 'holiday_name_check'},
            })
            request.done(function(res){
                var res_split = res.split(':r:');
                if(res_split[1] == 'error'){
                    $('#holiday_name').css('border-color', '#dc3545');
                    $('.invalid-feedback').show();
                    $('#holiday_name').val('');
                    return false;
                }else{
                    $('#holiday_name').css('border-color', '#0a58ca');
                    $('.invalid-feedback').hide();
                }
            })
        }
        
    })

    // 休業日設定表を削除
    $(document.body).on('click', '.remove_holiday_by_serial', function(){
        var holiday_serial = $(this).data('holiday_serial');
      
        if(confirm('休業日設定表を削除します。\nよろしいでしょうか？')){
            var request = $.ajax({
                type : 'POST',
                URL : BASE_AJAX_URL,
                data : {holiday_serial, p_kind : 'remove_holiday_by_serial'},
            })
            request.done(function(res){
                var res_split = res.split(':r:');
                if(res_split[1] != 'error'){
                    console.log("ok");
					location.reload();
                }
            })
        }
    })
    
   

    $('#set_calendar').click(function(){
       
        var holiday_name = $('#holiday_name').val();
        if(!holiday_name){
            alert('休業日設定表名を入力してください。');
            $('#holiday_name').focus();
            return false;
        }

        if(highlightedDates.length == 0){
            alert('休業日設定を設定してください。');
            return false;
        }
              

        $('#selected_calendar').val((highlightedDates));
        $('#p_kind').val('set_calendar');
        $('#register')[0].submit();

    })

    
});

