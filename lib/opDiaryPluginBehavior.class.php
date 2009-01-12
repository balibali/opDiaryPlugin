<?php

class opDiaryPluginBehavior
{
  public function deleteDiaryImage(File $object, PropelPDO $con = null)
  {
    foreach ($object->getDiaryImages() as $diaryImage)
    {
      $diaryImage->setDeleteFile(false);
      $diaryImage->delete();
    }
  }
}
