all:
  doctrine:
    class: sfDoctrineDatabase
    param:
      dsn: 'mysql:host=localhost;dbname=betterrecipes'
      username: br_dev
      password: goodPassword
      encoding: utf8
      persistent:
        value:  true
      attributes:
        quote_identifier: true
        use_native_enum: true
        validate: all
        idxname_format: %s_idx
        seqname_format: %s_seq
        tblname_format: %s
        DEFAULT_TABLE_TYPE: InnoDB
        DEFAULT_TABLE_CHARSET: utf8
        DEFAULT_TABLE_COLLATE: utf8_general_ci
