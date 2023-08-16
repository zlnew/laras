import { createAvatar } from '@dicebear/core';
import { initials } from '@dicebear/collection';

const avatar = (seed: string) => {
  const avt = createAvatar(initials, {
    seed: seed
  });
  return avt.toDataUriSync();
}

export {
  avatar
};
