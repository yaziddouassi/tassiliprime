import { defineStore } from 'pinia'

export const TassiliBulk = defineStore('bulk', {
  state: () => ({
    collections: {},
    bulkActifs : {},
    bulks: {},
    bulkTabs: {},
    bulkOpens : {},
    modalFormList : {},
  }),

  actions: {
   
      resetActionIds(cle) {  
        this.bulkTabs[cle] = []
        this.bulkOpens[cle] = 'no'
      },

       AddActionIds(cle,ide) {

        if (!this.bulkTabs[cle].includes(ide)) {
          this.bulkTabs[cle].push(ide);
        }
        
      },

      RemoveActionIds(cle,ide) {
    
        const index = this.bulkTabs[cle].indexOf(ide);
          if (index !== -1) {
                 this.bulkTabs[cle].splice(index, 1);
                }

           if(this.bulkTabs[cle].length == 0) {
           this.bulkOpens[cle] = 'no'
        }

      },

  }

})