import {FatherClass} from "./father";

class AdminPanelClass extends FatherClass{
    constructor(elem) {
        super(elem);
        this.data = backData;
        this.current_group = null;
        this.aCurrent_data = null;
        this.change_city = this.find('.change_city');
        this.allow_message = this.find('.allow_message');
        this.message_period = this.find('.message_period');
        this.message_type = this.find('.message_type');
        this.select_group = this.find('#groups');
        this.save = this.find('.save');

        this.events();
    }

    current_data(group_id){
        let result = null;
        this.data.map((v, k)=>{
            if( +v.group_id === +group_id) result = v;
        });
        this.current_group = result;
        return result;
    }

    toggle_interface(){
        if($(this.select_group).val()) {
            this.change_city.removeClass('hide');
            this.allow_message.removeClass('hide');
            this.message_period.removeClass('hide');
            this.message_type.removeClass('hide');
            this.save.removeClass('hide');
        }else{
            this.change_city.addClass('hide');
            this.allow_message.addClass('hide');
            this.message_period.addClass('hide');
            this.message_type.addClass('hide');
            this.save.addClass('hide');
        }
    }

    check_city(e){
        const group = this.current_data($(e?.currentTarget).val());
        const city = group['city'];
        this.change_city.find('select option').map((k, v)=>{
            $(v).val() === city && $(v).prop('selected', true);
        });
    }

    check_permission(e){
        const group = this.current_data($(e?.currentTarget).val());
        const bool = JSON.parse(group['allow_messages']);
        this.allow_message.find('input').prop('checked', bool);
    }

    check_period(e){
        const group = this.current_data($(e?.currentTarget).val());
        const period = JSON.parse(group['message_period']);
        this.message_period.find('input').map((k, v)=>{
            period[k] ? $(v).prop('checked', true) : $(v).prop('checked', false);
        });
    }

    check_message_type(e){
        const group = this.current_data($(e?.currentTarget).val());
        const type = JSON.parse(group['message_type']);
        this.message_type.find('input').map((k, v)=>{
            +$(v).val() === +type ? $(v).prop('checked', true) : $(v).prop('checked', false);
        });
    }

    changeCityHandler(e){
        const value = $(e.target).val();
        this.current_group['city'] = value ? value : 'Kyiv';
        this.aCurrent_data = {
            city: this.current_group.city,
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    changeMessagesPermission(){
        const value = this.allow_message.find('input[name="messages_permission"]').prop('checked');
        this.current_group['allow_messages'] = value ? 1 : 0;
        this.aCurrent_data = {
            city: this.current_group.city,
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    changePeriodHandler(){
        let result = [];
        this.message_period.find('input').map((k, v)=>{
            $(v).prop('checked') ? result.push(1) : result.push(0);
        });
        this.current_group['message_period'] = JSON.stringify(result);
        this.aCurrent_data = {
            city: this.current_group.city,
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    changeMessageTypeHandler(){
        const value = this.message_type.find('input[name="choose_msg_type"]:checked').val();
        this.current_group['message_type'] = `${value}`;
        this.aCurrent_data = {
            city: this.current_group.city,
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    all_save(){
        const url = `/crud/update_group_info/${this.current_group['id']}`;
        const data = {
            "_token": $('#token').val(),
            city: this.aCurrent_data.city,
            allow_messages: this.aCurrent_data.allow_messages,
            message_period: this.aCurrent_data.message_period,
            message_type: this.aCurrent_data.message_type,
        };
        $.post(url, data)
            .done((res) => {
                console.log(res);
                setTimeout(() => {location.reload()}, 500);
            });
    }

    selectGroupHandler(e){
        this.toggle_interface();
        this.check_city(e);
        this.check_permission(e);
        this.check_period(e);
        this.check_message_type(e);

        this.aCurrent_data = {
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    events(){
        this.select_group.on('change', this.selectGroupHandler.bind(this));
        this.change_city.on('change', this.changeCityHandler.bind(this));
        this.allow_message.on('change', this.changeMessagesPermission.bind(this));
        this.message_period.on('change', this.changePeriodHandler.bind(this));
        this.message_type.on('change', this.changeMessageTypeHandler.bind(this));
        this.save.on('click', this.all_save.bind(this));
        console.log(this.data);
    }
}
$(document).ready(() => {new AdminPanelClass('.adminpanel_wrap')});

