// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: addressbook.proto

// Protobuf Java Version: 3.25.1
package art.ameliah.ehb.shortburst.protobuf.impl.adressbook;

public final class AddressBookProtos {
  private AddressBookProtos() {}
  public static void registerAllExtensions(
      com.google.protobuf.ExtensionRegistryLite registry) {
  }

  public static void registerAllExtensions(
      com.google.protobuf.ExtensionRegistry registry) {
    registerAllExtensions(
        (com.google.protobuf.ExtensionRegistryLite) registry);
  }
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_ehb_shortburst_protobuf_Person_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_PhoneNumber_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_ehb_shortburst_protobuf_Person_PhoneNumber_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBook_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBook_fieldAccessorTable;

  public static com.google.protobuf.Descriptors.FileDescriptor
      getDescriptor() {
    return descriptor;
  }
  private static  com.google.protobuf.Descriptors.FileDescriptor
      descriptor;
  static {
    java.lang.String[] descriptorData = {
      "\n\021addressbook.proto\022#art.ameliah.ehb.sho" +
      "rtburst.protobuf\"\220\003\n\006Person\022\021\n\004name\030\001 \001(" +
      "\tH\000\210\001\001\022\017\n\002id\030\002 \001(\005H\001\210\001\001\022\022\n\005email\030\003 \001(\tH\002" +
      "\210\001\001\022G\n\006phones\030\004 \003(\01327.art.ameliah.ehb.sh" +
      "ortburst.protobuf.Person.PhoneNumber\032\200\001\n" +
      "\013PhoneNumber\022\023\n\006number\030\001 \001(\tH\000\210\001\001\022H\n\004typ" +
      "e\030\002 \001(\01625.art.ameliah.ehb.shortburst.pro" +
      "tobuf.Person.PhoneTypeH\001\210\001\001B\t\n\007_numberB\007" +
      "\n\005_type\"h\n\tPhoneType\022\032\n\026PHONE_TYPE_UNSPE" +
      "CIFIED\020\000\022\025\n\021PHONE_TYPE_MOBILE\020\001\022\023\n\017PHONE" +
      "_TYPE_HOME\020\002\022\023\n\017PHONE_TYPE_WORK\020\003B\007\n\005_na" +
      "meB\005\n\003_idB\010\n\006_email\"J\n\013AddressBook\022;\n\006pe" +
      "ople\030\001 \003(\0132+.art.ameliah.ehb.shortburst." +
      "protobuf.PersonB\222\001\n3art.ameliah.ehb.shor" +
      "tburst.protobuf.impl.adressbookB\021Address" +
      "BookProtosP\001ZFgithub.com/Fesaa/EHB/BA2/j" +
      "ava-advanced/short-burst-protobuf/server" +
      "/pbdb\006proto3"
    };
    descriptor = com.google.protobuf.Descriptors.FileDescriptor
      .internalBuildGeneratedFileFrom(descriptorData,
        new com.google.protobuf.Descriptors.FileDescriptor[] {
        });
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_descriptor =
      getDescriptor().getMessageTypes().get(0);
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_ehb_shortburst_protobuf_Person_descriptor,
        new java.lang.String[] { "Name", "Id", "Email", "Phones", });
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_PhoneNumber_descriptor =
      internal_static_art_ameliah_ehb_shortburst_protobuf_Person_descriptor.getNestedTypes().get(0);
    internal_static_art_ameliah_ehb_shortburst_protobuf_Person_PhoneNumber_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_ehb_shortburst_protobuf_Person_PhoneNumber_descriptor,
        new java.lang.String[] { "Number", "Type", });
    internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBook_descriptor =
      getDescriptor().getMessageTypes().get(1);
    internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBook_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBook_descriptor,
        new java.lang.String[] { "People", });
  }

  // @@protoc_insertion_point(outer_class_scope)
}
