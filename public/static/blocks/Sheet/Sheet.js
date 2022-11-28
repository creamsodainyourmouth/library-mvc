const checkbox_all_checker_selector = '.Checkbox--AllChecker';
const checkbox_selector = '.Ceil__Checkbox';


// const btn_order_book = document.querySelector('.BookOrder__Btn');
const btn_mass_edit = document.querySelector('.Btn--MassEdit');
const checkbox_all_checker = document.querySelector(checkbox_all_checker_selector);

function check_selects(event)
{
    let checkboxes = [...document.querySelectorAll(checkbox_selector)];
    let is_select = checkboxes.some((checkbox)=> {
        return checkbox.checked === true;
    });
    if (!is_select) {
        event.preventDefault();
    }
}

function check_all()
{
    document.querySelectorAll(checkbox_selector).forEach((checkbox)=> {
        checkbox.checked = this.checked;
    });
}

function check_dates(event)
{
    let dates = [...document.querySelectorAll('.BookOrder__Date')];
    let has_empty = dates.some((date)=> {
        return date.value === "";
    });
    if (has_empty) {
        event.preventDefault();
    }
}


// btn_order_book.addEventListener('click', check_dates);
checkbox_all_checker.addEventListener('click', check_all);
btn_mass_edit.addEventListener('click', check_selects);


