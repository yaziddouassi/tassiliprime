import { usePage } from '@inertiajs/vue3'
import { TassiliRoutes } from '@/vendor/TassiliLibs/stores/tassiliRoutes'
import {TassiliInput}    from '@/vendor/TassiliLibs/stores/tassiliInput'
import { TassiliBulk } from '../stores/tassiliBulk'

export function formService() {
  

  function setForm() {
   const page = usePage()
   const tassiliroutes  = TassiliRoutes();
   const tassiliInput = TassiliInput()
   const tassiliBulk = TassiliBulk()

   tassiliroutes.setRoutes(page.props.tassiliSettings.routes,page.props.tassiliSettings.tassiliPanel)
   tassiliInput.tassiliFormList = page.props.tassiliSettings.tassiliFormList
   tassiliInput.customActionModal = false
   tassiliBulk.collections = page.props.tassiliSettings.collections
   tassiliBulk.bulkActifs = page.props.tassiliSettings.bulkActifs
   tassiliBulk.modalFormList = page.props.tassiliSettings.modalFormList
   tassiliBulk.bulks = page.props.tassiliSettings.bulks
   tassiliBulk.bulkTabs = page.props.tassiliSettings.bulkTabs
   tassiliBulk.bulkOpens = page.props.tassiliSettings.bulkOpens
  }

 

  return {
    setForm
  }
}