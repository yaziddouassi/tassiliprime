import { defineStore } from 'pinia'
import { usePage } from '@inertiajs/vue3'

export const Permission = defineStore('permissions', () => {
    const page = usePage()
    const permissions = page.props.tassiliSettings.permissions

    /**
     * @param {string[]} permissionsRequired
     */
    function can(permissionsRequired) {
        if (!permissionsRequired.length) return true
        if (!permissions.length) return false

        return permissionsRequired.some(p => permissions.includes(p))
    }

    return { can }
})