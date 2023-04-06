import {FatherClass} from "./father";

class WelcomeClass extends FatherClass{
    constructor(elem) {
        super(elem);
        this.days = this.find('.day');
        this.details = this.find('.detail');

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

    events(){
        this.days.on('click', this.toggle_details.bind(this))
    }
}
$(document).ready(() => {new WelcomeClass('.main')});
