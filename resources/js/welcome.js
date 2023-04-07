import {FatherClass} from "./father";

class WelcomeClass extends FatherClass{
    constructor(elem) {
        super(elem);
        this.days = this.find('.day');
        this.details = this.find('.detail');
        this.change_city = this.find('.change_city');

        this.events();
    }

    toggle_details(e){
        const index = $(e.currentTarget).index();
        this.details.map((k, v)=>{
            if(k === index){
                $(v).addClass('show-detail');
            }else{
                $(v).removeClass('show-detail');
            }
        });
    }

    change_city_handler(e){
        const city = e.currentTarget.value;
        $.get(`/change_city/${city}`, (result) => {console.log(result);});
        setTimeout(() => {location.reload()}, 500);
    }

    events(){
        this.change_city.on('change', this.change_city_handler.bind(this));
        this.days.on('click', this.toggle_details.bind(this))
    }
}
$(document).ready(() => {new WelcomeClass('.main')});
