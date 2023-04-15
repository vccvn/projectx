import { FormControl } from '@angular/forms';

export function noWhitespaceValidator(control: FormControl) {
  if (control.value === '') {
    return null;
  }
  if (!control.value) {
    return null;
  }
  const isWhitespace = (control.value || '').trim().length === 0;
  const isValid = !isWhitespace;
  return isValid ? null : { whitespace: true };
}
