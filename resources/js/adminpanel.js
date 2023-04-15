import {FatherClass} from "./father";

class AdminPanelClass extends FatherClass{
    constructor(elem) {
        super(elem);
        this.data = backData;
        this.current_group = null;
        this.aCurrent_data = null;
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
            result = +v.group_id === +group_id && v;
        });
        this.current_group = result;
        return result;
    }

    toggle_interface(){
        if($(this.select_group).val()) {
            this.allow_message.removeClass('hide');
            this.message_period.removeClass('hide');
            this.message_type.removeClass('hide');
            this.save.removeClass('hide');
        }else{
            this.allow_message.addClass('hide');
            this.message_period.addClass('hide');
            this.message_type.addClass('hide');
            this.save.addClass('hide');
        }
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

    changeMessagesPermission(){
        const value = this.allow_message.find('input[name="messages_permission"]').prop('checked');
        this.current_group['allow_messages'] = value ? 1 : 0;
        this.aCurrent_data = {
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
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    changeMessageTypeHandler(){
        const value = this.message_type.find('input[name="choose_msg_type"]:checked').val();
        this.current_group['message_type'] = `${value}`;
        this.aCurrent_data = {
            allow_messages: this.current_group.allow_messages,
            message_period: this.current_group.message_period,
            message_type: this.current_group.message_type,
        };
    }

    all_save(){
        const url = `/crud/update_group_info/${this.current_group['id']}`;
        const data = {
            "_token": $('#token').val(),
            allow_messages: this.aCurrent_data.allow_messages,
            message_period: this.aCurrent_data.message_period,
            message_type: this.aCurrent_data.message_type,
        };
        $.post(url, data)
            .done((res) => {
                console.log(res);
            });
    }

    selectGroupHandler(e){
        this.toggle_interface();
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
        this.allow_message.on('change', this.changeMessagesPermission.bind(this));
        this.message_period.on('change', this.changePeriodHandler.bind(this));
        this.message_type.on('change', this.changeMessageTypeHandler.bind(this));
        this.save.on('click', this.all_save.bind(this));
        console.log(this.data);
    }
}
$(document).ready(() => {new AdminPanelClass('.adminpanel_wrap')});
