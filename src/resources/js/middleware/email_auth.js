import { config } from '~/plugins/config'

export default async (to, from, next) => {
  if (!config('settings.users.email_auth')) {
    next({ name: 'home' })
  } else {
    next()
  }
}
