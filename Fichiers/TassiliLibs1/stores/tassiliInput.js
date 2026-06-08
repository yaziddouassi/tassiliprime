import { defineStore } from 'pinia'

export const TassiliInput = defineStore('counter', {
  state: () => ({
    form : {},
    formStart : {},
    formInfo : {},
    wizardInfo : {},
    wizardCurrent : 1,
    errors: {}, 
    tassiliFormList : {},
    customActionModal: false,
    formType : '',
    urlCustomValidation : '',
    isAnimated : 'off' ,
  }),

  actions: {
    setError(cle,err) {
      this.errors[cle] = err
    },

    resetError() {
      this.errors = {}
    },

    cancelError(cle) {
      this.errors[cle] = {}
    },

    openFormCreate(cle) {
     this.urlCustomValidation = cle
     this.form[cle] = JSON.parse(JSON.stringify(this.tassiliFormList[this.urlCustomValidation]['fields']))
     this.customActionModal = true
     this.formType = 'type1'
    },

    openWizardCreate(cle) {
     this.urlCustomValidation = cle
     this.form[cle] = JSON.parse(JSON.stringify(this.tassiliFormList[this.urlCustomValidation]['fields']))
     this.customActionModal = true
     this.formType = 'type2' 
    },

    openFormUpdate(cle,record) {
     this.urlCustomValidation = cle
     this.form[cle] = JSON.parse(JSON.stringify(this.tassiliFormList[this.urlCustomValidation]['fields']))
     this.recordAction = record
     this.customActionModal = true
     this.formType = 'type3'
     this.putRecord()
    },
    openWizardUpdate(cle,record) {
     this.urlCustomValidation = cle
     this.form[cle] = JSON.parse(JSON.stringify(this.tassiliFormList[this.urlCustomValidation]['fields']))
     this.recordAction = record
     this.customActionModal = true
     this.formType = 'type4'
     this.putRecord()
    },

    putRecord() {

Object.entries(this.recordAction).forEach(([key, value]) => {
  
if(key in this.form[this.urlCustomValidation]) {

const tab1 = ['Text','Date','Number','Hidden','Select','Checkbox','Radio','Quill','Textarea','Signature'];

if(tab1.includes(this.form[this.urlCustomValidation][key]['type'])) {

this.form[this.urlCustomValidation][key]['value'] = value
}

else if(this.form[this.urlCustomValidation][key]['type']  == 'File') {
this.form[this.urlCustomValidation][key]['options']['urlRecord'] = value
}

else if(this.form[this.urlCustomValidation][key]['type']  === 'CheckboxList'  || 
   this.form[this.urlCustomValidation][key]['type']  === 'Repeater') {

  const data = new Proxy(
  JSON.parse(value),
  {}
);
  this.form[this.urlCustomValidation][key]['value'] = data
}

else if(this.form[this.urlCustomValidation][key]['type']  === 'MultipleFile') {

 const data = new Proxy(
 JSON.parse(value) ,
  {}
);

 this.form[this.urlCustomValidation][key]['options']['existingFiles'] = data

}

  }
});

    },


  }



})