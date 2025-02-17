import { add } from './add';

test('1 + 1 should equal 2', () => {
  expect(add(1, 1)).toBe(3);
});

test('1 + 2 should not equal 4', () => {
  expect(add(1, 2)).not.toBe(4);
});
