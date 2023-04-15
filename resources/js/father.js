export class FatherClass {
    constructor(elem) {
        this.el = $(elem);
    }

    find(sSelector){
        return this.el.find(sSelector);
    }

    #fetch_field(data, field){
        field && field.map((k, v)=>{
            data[$(v).attr('name')] = $(v).val();
        });
    }

    values(form){  // inputs must have name
        let data = {};
        let input = $(form).find('input');
        let textarea = $(form).find('textarea');
        let select = $(form).find('select');

        this.#fetch_field(data, input);
        this.#fetch_field(data, textarea);
        this.#fetch_field(data, select);

        return data;
    }
}
