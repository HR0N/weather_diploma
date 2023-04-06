export class FatherClass {
    constructor(elem) {
        this.el = $(elem);
    }

    find(sSelector){
        return this.el.find(sSelector);
    }
}
