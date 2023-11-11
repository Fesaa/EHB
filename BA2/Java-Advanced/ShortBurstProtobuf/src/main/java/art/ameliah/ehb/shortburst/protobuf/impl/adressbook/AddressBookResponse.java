// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: addressbook.proto

// Protobuf Java Version: 3.25.0
package art.ameliah.ehb.shortburst.protobuf.impl.adressbook;

/**
 * Protobuf type {@code art.ameliah.ehb.shortburst.protobuf.AddressBookResponse}
 */
public final class AddressBookResponse extends
    com.google.protobuf.GeneratedMessageV3 implements
    // @@protoc_insertion_point(message_implements:art.ameliah.ehb.shortburst.protobuf.AddressBookResponse)
    AddressBookResponseOrBuilder {
private static final long serialVersionUID = 0L;
  // Use AddressBookResponse.newBuilder() to construct.
  private AddressBookResponse(com.google.protobuf.GeneratedMessageV3.Builder<?> builder) {
    super(builder);
  }
  private AddressBookResponse() {
    error_ = "";
  }

  @java.lang.Override
  @SuppressWarnings({"unused"})
  protected java.lang.Object newInstance(
      UnusedPrivateParameter unused) {
    return new AddressBookResponse();
  }

  public static final com.google.protobuf.Descriptors.Descriptor
      getDescriptor() {
    return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookProtos.internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBookResponse_descriptor;
  }

  @java.lang.Override
  protected com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internalGetFieldAccessorTable() {
    return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookProtos.internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBookResponse_fieldAccessorTable
        .ensureFieldAccessorsInitialized(
            art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.class, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.Builder.class);
  }

  private int bitField0_;
  public static final int BOOK_FIELD_NUMBER = 1;
  private art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook book_;
  /**
   * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
   * @return Whether the book field is set.
   */
  @java.lang.Override
  public boolean hasBook() {
    return ((bitField0_ & 0x00000001) != 0);
  }
  /**
   * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
   * @return The book.
   */
  @java.lang.Override
  public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook getBook() {
    return book_ == null ? art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.getDefaultInstance() : book_;
  }
  /**
   * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
   */
  @java.lang.Override
  public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookOrBuilder getBookOrBuilder() {
    return book_ == null ? art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.getDefaultInstance() : book_;
  }

  public static final int ERROR_FIELD_NUMBER = 3;
  @SuppressWarnings("serial")
  private volatile java.lang.Object error_ = "";
  /**
   * <code>optional string error = 3;</code>
   * @return Whether the error field is set.
   */
  @java.lang.Override
  public boolean hasError() {
    return ((bitField0_ & 0x00000002) != 0);
  }
  /**
   * <code>optional string error = 3;</code>
   * @return The error.
   */
  @java.lang.Override
  public java.lang.String getError() {
    java.lang.Object ref = error_;
    if (ref instanceof java.lang.String) {
      return (java.lang.String) ref;
    } else {
      com.google.protobuf.ByteString bs = 
          (com.google.protobuf.ByteString) ref;
      java.lang.String s = bs.toStringUtf8();
      error_ = s;
      return s;
    }
  }
  /**
   * <code>optional string error = 3;</code>
   * @return The bytes for error.
   */
  @java.lang.Override
  public com.google.protobuf.ByteString
      getErrorBytes() {
    java.lang.Object ref = error_;
    if (ref instanceof java.lang.String) {
      com.google.protobuf.ByteString b = 
          com.google.protobuf.ByteString.copyFromUtf8(
              (java.lang.String) ref);
      error_ = b;
      return b;
    } else {
      return (com.google.protobuf.ByteString) ref;
    }
  }

  private byte memoizedIsInitialized = -1;
  @java.lang.Override
  public final boolean isInitialized() {
    byte isInitialized = memoizedIsInitialized;
    if (isInitialized == 1) return true;
    if (isInitialized == 0) return false;

    memoizedIsInitialized = 1;
    return true;
  }

  @java.lang.Override
  public void writeTo(com.google.protobuf.CodedOutputStream output)
                      throws java.io.IOException {
    if (((bitField0_ & 0x00000001) != 0)) {
      output.writeMessage(1, getBook());
    }
    if (((bitField0_ & 0x00000002) != 0)) {
      com.google.protobuf.GeneratedMessageV3.writeString(output, 3, error_);
    }
    getUnknownFields().writeTo(output);
  }

  @java.lang.Override
  public int getSerializedSize() {
    int size = memoizedSize;
    if (size != -1) return size;

    size = 0;
    if (((bitField0_ & 0x00000001) != 0)) {
      size += com.google.protobuf.CodedOutputStream
        .computeMessageSize(1, getBook());
    }
    if (((bitField0_ & 0x00000002) != 0)) {
      size += com.google.protobuf.GeneratedMessageV3.computeStringSize(3, error_);
    }
    size += getUnknownFields().getSerializedSize();
    memoizedSize = size;
    return size;
  }

  @java.lang.Override
  public boolean equals(final java.lang.Object obj) {
    if (obj == this) {
     return true;
    }
    if (!(obj instanceof art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse)) {
      return super.equals(obj);
    }
    art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse other = (art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse) obj;

    if (hasBook() != other.hasBook()) return false;
    if (hasBook()) {
      if (!getBook()
          .equals(other.getBook())) return false;
    }
    if (hasError() != other.hasError()) return false;
    if (hasError()) {
      if (!getError()
          .equals(other.getError())) return false;
    }
    if (!getUnknownFields().equals(other.getUnknownFields())) return false;
    return true;
  }

  @java.lang.Override
  public int hashCode() {
    if (memoizedHashCode != 0) {
      return memoizedHashCode;
    }
    int hash = 41;
    hash = (19 * hash) + getDescriptor().hashCode();
    if (hasBook()) {
      hash = (37 * hash) + BOOK_FIELD_NUMBER;
      hash = (53 * hash) + getBook().hashCode();
    }
    if (hasError()) {
      hash = (37 * hash) + ERROR_FIELD_NUMBER;
      hash = (53 * hash) + getError().hashCode();
    }
    hash = (29 * hash) + getUnknownFields().hashCode();
    memoizedHashCode = hash;
    return hash;
  }

  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      java.nio.ByteBuffer data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      java.nio.ByteBuffer data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      com.google.protobuf.ByteString data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      com.google.protobuf.ByteString data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(byte[] data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      byte[] data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(java.io.InputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      java.io.InputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input, extensionRegistry);
  }

  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseDelimitedFrom(java.io.InputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseDelimitedWithIOException(PARSER, input);
  }

  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseDelimitedFrom(
      java.io.InputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseDelimitedWithIOException(PARSER, input, extensionRegistry);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      com.google.protobuf.CodedInputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input);
  }
  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse parseFrom(
      com.google.protobuf.CodedInputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input, extensionRegistry);
  }

  @java.lang.Override
  public Builder newBuilderForType() { return newBuilder(); }
  public static Builder newBuilder() {
    return DEFAULT_INSTANCE.toBuilder();
  }
  public static Builder newBuilder(art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse prototype) {
    return DEFAULT_INSTANCE.toBuilder().mergeFrom(prototype);
  }
  @java.lang.Override
  public Builder toBuilder() {
    return this == DEFAULT_INSTANCE
        ? new Builder() : new Builder().mergeFrom(this);
  }

  @java.lang.Override
  protected Builder newBuilderForType(
      com.google.protobuf.GeneratedMessageV3.BuilderParent parent) {
    Builder builder = new Builder(parent);
    return builder;
  }
  /**
   * Protobuf type {@code art.ameliah.ehb.shortburst.protobuf.AddressBookResponse}
   */
  public static final class Builder extends
      com.google.protobuf.GeneratedMessageV3.Builder<Builder> implements
      // @@protoc_insertion_point(builder_implements:art.ameliah.ehb.shortburst.protobuf.AddressBookResponse)
      art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponseOrBuilder {
    public static final com.google.protobuf.Descriptors.Descriptor
        getDescriptor() {
      return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookProtos.internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBookResponse_descriptor;
    }

    @java.lang.Override
    protected com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
        internalGetFieldAccessorTable() {
      return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookProtos.internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBookResponse_fieldAccessorTable
          .ensureFieldAccessorsInitialized(
              art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.class, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.Builder.class);
    }

    // Construct using art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.newBuilder()
    private Builder() {
      maybeForceBuilderInitialization();
    }

    private Builder(
        com.google.protobuf.GeneratedMessageV3.BuilderParent parent) {
      super(parent);
      maybeForceBuilderInitialization();
    }
    private void maybeForceBuilderInitialization() {
      if (com.google.protobuf.GeneratedMessageV3
              .alwaysUseFieldBuilders) {
        getBookFieldBuilder();
      }
    }
    @java.lang.Override
    public Builder clear() {
      super.clear();
      bitField0_ = 0;
      book_ = null;
      if (bookBuilder_ != null) {
        bookBuilder_.dispose();
        bookBuilder_ = null;
      }
      error_ = "";
      return this;
    }

    @java.lang.Override
    public com.google.protobuf.Descriptors.Descriptor
        getDescriptorForType() {
      return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookProtos.internal_static_art_ameliah_ehb_shortburst_protobuf_AddressBookResponse_descriptor;
    }

    @java.lang.Override
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse getDefaultInstanceForType() {
      return art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.getDefaultInstance();
    }

    @java.lang.Override
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse build() {
      art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse result = buildPartial();
      if (!result.isInitialized()) {
        throw newUninitializedMessageException(result);
      }
      return result;
    }

    @java.lang.Override
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse buildPartial() {
      art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse result = new art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse(this);
      if (bitField0_ != 0) { buildPartial0(result); }
      onBuilt();
      return result;
    }

    private void buildPartial0(art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse result) {
      int from_bitField0_ = bitField0_;
      int to_bitField0_ = 0;
      if (((from_bitField0_ & 0x00000001) != 0)) {
        result.book_ = bookBuilder_ == null
            ? book_
            : bookBuilder_.build();
        to_bitField0_ |= 0x00000001;
      }
      if (((from_bitField0_ & 0x00000002) != 0)) {
        result.error_ = error_;
        to_bitField0_ |= 0x00000002;
      }
      result.bitField0_ |= to_bitField0_;
    }

    @java.lang.Override
    public Builder clone() {
      return super.clone();
    }
    @java.lang.Override
    public Builder setField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        java.lang.Object value) {
      return super.setField(field, value);
    }
    @java.lang.Override
    public Builder clearField(
        com.google.protobuf.Descriptors.FieldDescriptor field) {
      return super.clearField(field);
    }
    @java.lang.Override
    public Builder clearOneof(
        com.google.protobuf.Descriptors.OneofDescriptor oneof) {
      return super.clearOneof(oneof);
    }
    @java.lang.Override
    public Builder setRepeatedField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        int index, java.lang.Object value) {
      return super.setRepeatedField(field, index, value);
    }
    @java.lang.Override
    public Builder addRepeatedField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        java.lang.Object value) {
      return super.addRepeatedField(field, value);
    }
    @java.lang.Override
    public Builder mergeFrom(com.google.protobuf.Message other) {
      if (other instanceof art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse) {
        return mergeFrom((art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse)other);
      } else {
        super.mergeFrom(other);
        return this;
      }
    }

    public Builder mergeFrom(art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse other) {
      if (other == art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse.getDefaultInstance()) return this;
      if (other.hasBook()) {
        mergeBook(other.getBook());
      }
      if (other.hasError()) {
        error_ = other.error_;
        bitField0_ |= 0x00000002;
        onChanged();
      }
      this.mergeUnknownFields(other.getUnknownFields());
      onChanged();
      return this;
    }

    @java.lang.Override
    public final boolean isInitialized() {
      return true;
    }

    @java.lang.Override
    public Builder mergeFrom(
        com.google.protobuf.CodedInputStream input,
        com.google.protobuf.ExtensionRegistryLite extensionRegistry)
        throws java.io.IOException {
      if (extensionRegistry == null) {
        throw new java.lang.NullPointerException();
      }
      try {
        boolean done = false;
        while (!done) {
          int tag = input.readTag();
          switch (tag) {
            case 0:
              done = true;
              break;
            case 10: {
              input.readMessage(
                  getBookFieldBuilder().getBuilder(),
                  extensionRegistry);
              bitField0_ |= 0x00000001;
              break;
            } // case 10
            case 26: {
              error_ = input.readStringRequireUtf8();
              bitField0_ |= 0x00000002;
              break;
            } // case 26
            default: {
              if (!super.parseUnknownField(input, extensionRegistry, tag)) {
                done = true; // was an endgroup tag
              }
              break;
            } // default:
          } // switch (tag)
        } // while (!done)
      } catch (com.google.protobuf.InvalidProtocolBufferException e) {
        throw e.unwrapIOException();
      } finally {
        onChanged();
      } // finally
      return this;
    }
    private int bitField0_;

    private art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook book_;
    private com.google.protobuf.SingleFieldBuilderV3<
        art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.Builder, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookOrBuilder> bookBuilder_;
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     * @return Whether the book field is set.
     */
    public boolean hasBook() {
      return ((bitField0_ & 0x00000001) != 0);
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     * @return The book.
     */
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook getBook() {
      if (bookBuilder_ == null) {
        return book_ == null ? art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.getDefaultInstance() : book_;
      } else {
        return bookBuilder_.getMessage();
      }
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public Builder setBook(art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook value) {
      if (bookBuilder_ == null) {
        if (value == null) {
          throw new NullPointerException();
        }
        book_ = value;
      } else {
        bookBuilder_.setMessage(value);
      }
      bitField0_ |= 0x00000001;
      onChanged();
      return this;
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public Builder setBook(
        art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.Builder builderForValue) {
      if (bookBuilder_ == null) {
        book_ = builderForValue.build();
      } else {
        bookBuilder_.setMessage(builderForValue.build());
      }
      bitField0_ |= 0x00000001;
      onChanged();
      return this;
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public Builder mergeBook(art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook value) {
      if (bookBuilder_ == null) {
        if (((bitField0_ & 0x00000001) != 0) &&
          book_ != null &&
          book_ != art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.getDefaultInstance()) {
          getBookBuilder().mergeFrom(value);
        } else {
          book_ = value;
        }
      } else {
        bookBuilder_.mergeFrom(value);
      }
      if (book_ != null) {
        bitField0_ |= 0x00000001;
        onChanged();
      }
      return this;
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public Builder clearBook() {
      bitField0_ = (bitField0_ & ~0x00000001);
      book_ = null;
      if (bookBuilder_ != null) {
        bookBuilder_.dispose();
        bookBuilder_ = null;
      }
      onChanged();
      return this;
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.Builder getBookBuilder() {
      bitField0_ |= 0x00000001;
      onChanged();
      return getBookFieldBuilder().getBuilder();
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookOrBuilder getBookOrBuilder() {
      if (bookBuilder_ != null) {
        return bookBuilder_.getMessageOrBuilder();
      } else {
        return book_ == null ?
            art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.getDefaultInstance() : book_;
      }
    }
    /**
     * <code>optional .art.ameliah.ehb.shortburst.protobuf.AddressBook book = 1;</code>
     */
    private com.google.protobuf.SingleFieldBuilderV3<
        art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.Builder, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookOrBuilder> 
        getBookFieldBuilder() {
      if (bookBuilder_ == null) {
        bookBuilder_ = new com.google.protobuf.SingleFieldBuilderV3<
            art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook.Builder, art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookOrBuilder>(
                getBook(),
                getParentForChildren(),
                isClean());
        book_ = null;
      }
      return bookBuilder_;
    }

    private java.lang.Object error_ = "";
    /**
     * <code>optional string error = 3;</code>
     * @return Whether the error field is set.
     */
    public boolean hasError() {
      return ((bitField0_ & 0x00000002) != 0);
    }
    /**
     * <code>optional string error = 3;</code>
     * @return The error.
     */
    public java.lang.String getError() {
      java.lang.Object ref = error_;
      if (!(ref instanceof java.lang.String)) {
        com.google.protobuf.ByteString bs =
            (com.google.protobuf.ByteString) ref;
        java.lang.String s = bs.toStringUtf8();
        error_ = s;
        return s;
      } else {
        return (java.lang.String) ref;
      }
    }
    /**
     * <code>optional string error = 3;</code>
     * @return The bytes for error.
     */
    public com.google.protobuf.ByteString
        getErrorBytes() {
      java.lang.Object ref = error_;
      if (ref instanceof String) {
        com.google.protobuf.ByteString b = 
            com.google.protobuf.ByteString.copyFromUtf8(
                (java.lang.String) ref);
        error_ = b;
        return b;
      } else {
        return (com.google.protobuf.ByteString) ref;
      }
    }
    /**
     * <code>optional string error = 3;</code>
     * @param value The error to set.
     * @return This builder for chaining.
     */
    public Builder setError(
        java.lang.String value) {
      if (value == null) { throw new NullPointerException(); }
      error_ = value;
      bitField0_ |= 0x00000002;
      onChanged();
      return this;
    }
    /**
     * <code>optional string error = 3;</code>
     * @return This builder for chaining.
     */
    public Builder clearError() {
      error_ = getDefaultInstance().getError();
      bitField0_ = (bitField0_ & ~0x00000002);
      onChanged();
      return this;
    }
    /**
     * <code>optional string error = 3;</code>
     * @param value The bytes for error to set.
     * @return This builder for chaining.
     */
    public Builder setErrorBytes(
        com.google.protobuf.ByteString value) {
      if (value == null) { throw new NullPointerException(); }
      checkByteStringIsUtf8(value);
      error_ = value;
      bitField0_ |= 0x00000002;
      onChanged();
      return this;
    }
    @java.lang.Override
    public final Builder setUnknownFields(
        final com.google.protobuf.UnknownFieldSet unknownFields) {
      return super.setUnknownFields(unknownFields);
    }

    @java.lang.Override
    public final Builder mergeUnknownFields(
        final com.google.protobuf.UnknownFieldSet unknownFields) {
      return super.mergeUnknownFields(unknownFields);
    }


    // @@protoc_insertion_point(builder_scope:art.ameliah.ehb.shortburst.protobuf.AddressBookResponse)
  }

  // @@protoc_insertion_point(class_scope:art.ameliah.ehb.shortburst.protobuf.AddressBookResponse)
  private static final art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse DEFAULT_INSTANCE;
  static {
    DEFAULT_INSTANCE = new art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse();
  }

  public static art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse getDefaultInstance() {
    return DEFAULT_INSTANCE;
  }

  private static final com.google.protobuf.Parser<AddressBookResponse>
      PARSER = new com.google.protobuf.AbstractParser<AddressBookResponse>() {
    @java.lang.Override
    public AddressBookResponse parsePartialFrom(
        com.google.protobuf.CodedInputStream input,
        com.google.protobuf.ExtensionRegistryLite extensionRegistry)
        throws com.google.protobuf.InvalidProtocolBufferException {
      Builder builder = newBuilder();
      try {
        builder.mergeFrom(input, extensionRegistry);
      } catch (com.google.protobuf.InvalidProtocolBufferException e) {
        throw e.setUnfinishedMessage(builder.buildPartial());
      } catch (com.google.protobuf.UninitializedMessageException e) {
        throw e.asInvalidProtocolBufferException().setUnfinishedMessage(builder.buildPartial());
      } catch (java.io.IOException e) {
        throw new com.google.protobuf.InvalidProtocolBufferException(e)
            .setUnfinishedMessage(builder.buildPartial());
      }
      return builder.buildPartial();
    }
  };

  public static com.google.protobuf.Parser<AddressBookResponse> parser() {
    return PARSER;
  }

  @java.lang.Override
  public com.google.protobuf.Parser<AddressBookResponse> getParserForType() {
    return PARSER;
  }

  @java.lang.Override
  public art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBookResponse getDefaultInstanceForType() {
    return DEFAULT_INSTANCE;
  }

}

