---
title: Supported Field Types
---

This package works by mapping database schema column types to a custom `Field` class. The supported field types and their corresponding database column types are given below.

| Field Type      | Column Types                                        |
|-----------------|-----------------------------------------------------|
| BooleanField    | `tinyint(1)`                                        |
| DateField       | `date`                                              |
| DateTimeField   | `datetime`, `timestamp`                             |
| DecimalField    | `double`, `decimal`, `dec`, `float`                 |
| EnumField       | `enum`, `set`                                       |
| ForeignKeyField | `Foreign`                                           |
| IntegerField    | `tinyint`, `smallint`, `mediumint`, `int`, `bigint` |
| JsonField       | `json`                                              |
| StringField     | `varchar`, `char`                                   |
| TextField       | `text`                                              |
| TimeField       | `time`                                              |
| YearField       | `year`                                              |

Currently, morphs and pivots are not supported. Any unsupported column type will simply be skipped by the generators. 
